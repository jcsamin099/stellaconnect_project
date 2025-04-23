function

<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rposystem";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SweetAlert function
function sweetAlertRedirect($title, $text, $icon, $redirect) {
    echo "
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: '$title',
                text: '$text',
                icon: '$icon',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '$redirect';
            });
        </script>
    </body>
    </html>";
    exit;
}

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    sweetAlertRedirect('Empty Cart!', 'No items in the cart. Please add items before proceeding to checkout.', 'warning', 'orders.php');
}

$dborder_id     = $_POST['order_id'];
$order_code     = $_POST['order_code'];
$customer_id    = $_POST['customer_id'];
$customer_name  = $_POST['customer_name'];
$prod_id        = 'e769e274a3';
$prod_name      = $_POST['pick_up'];
$prod_price     = 0;
$prod_qty       = 0;

// Check customer existence
$checkStmt = $conn->prepare("SELECT customer_id FROM rpos_customers WHERE customer_id = ?");
$checkStmt->bind_param('s', $customer_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows == 0) {
    sweetAlertRedirect('Customer Not Found!', 'The customer does not exist in the system.', 'error', 'orders.php');
}

// Begin transaction
$conn->begin_transaction();

try {
    // Insert order
    $postStmt = $conn->prepare("INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $postStmt->bind_param('ssssssss', $prod_qty, $dborder_id, $order_code, $customer_id, $customer_name, $prod_id, $prod_name, $prod_price);
    $postStmt->execute();

    // Prepare purchase_detail insert
    $detailStmt = $conn->prepare("INSERT INTO purchase_detail (order_id, prod_id, prod_qty) VALUES (?, ?, ?)");

    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item["product_id"];
        $quantity   = $item["quantity"];
        $price      = $item["price"];

        $detailStmt->bind_param('ssi', $dborder_id, $product_id, $quantity);
        $detailStmt->execute();

        $total += $quantity * $price;
    }

    // Update order total
    $updateStmt = $conn->prepare("UPDATE rpos_orders SET prod_price = ? WHERE order_id = ?");
    $updateStmt->bind_param('ds', $total, $dborder_id);
    $updateStmt->execute();

    // Commit transaction
    $conn->commit();

    // Empty cart
    unset($_SESSION["cart"]);

    header("Location: orders.php?success_id=1");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    sweetAlertRedirect('Transaction Failed!', $e->getMessage(), 'error', 'orders.php');
}
?>
