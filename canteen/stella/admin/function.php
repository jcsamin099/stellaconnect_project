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

$dborder_id = $_POST['order_id'];
$order_code  = $_POST['order_code'];
$customer_id = $_POST['customer_id'];
$customer_name = $_POST['customer_name'];
$prod_id  = 'e769e274a3';
$prod_name = $_POST['pick_up'];
$prod_price = '0';
$prod_qty = '0';

// Check if the customer exists
$checkCustomerQuery = "SELECT customer_id FROM rpos_customers WHERE customer_id = ?";
$checkStmt = $conn->prepare($checkCustomerQuery);
$checkStmt->bind_param('s', $customer_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows == 0) {
    // Customer does not exist, return an error message or handle accordingly
    echo "Error: Customer does not exist!";
    exit;
}

$total = 0; 

// Insert the order if customer exists
$postQuery = "INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES(?,?,?,?,?,?,?,?)";
$postStmt = $conn->prepare($postQuery);
//bind paramaters
$rc = $postStmt->bind_param('ssssssss', $prod_qty, $dborder_id, $order_code, $customer_id, $customer_name, $prod_id, $prod_name, $prod_price);
$postStmt->execute();

foreach ($_SESSION['cart'] as $item1 => $details1){

    $product_id = $details1["product_id"];
    $order_id = $dborder_id;
    $quantity = $details1["quantity"];

    $sql="insert into purchase_detail (order_id, prod_id, prod_qty) values ('$order_id', '$product_id', '$quantity')";
    $result1 =  $conn->query($sql);

    $total += $details1['quantity'] * $details1['price'];

}

// Update the order with the total price
$sql="update rpos_orders set prod_price='$total' where order_id='$dborder_id' ";
$conn->query($sql);

// If purchase details are inserted successfully, empty the cart
if($result1 == TRUE){
    foreach ( $_SESSION["cart"] as $keys => $values) {
        unset($_SESSION["cart"][$keys]);
        echo '<script>window.open("orders.php?success_id=1","_self")</script>';
    }
} else {
    echo 'Fail';
}
?>
