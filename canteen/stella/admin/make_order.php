<?php

session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['prod_id']) && isset($_POST['quantity'])) {
        $prod_id = $_POST['prod_id'];
        $quantity = intval($_POST['quantity']);
        
        $sql = "SELECT * FROM rpos_products WHERE prod_id = $prod_id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($quantity > 0) {
                if (isset($_SESSION['cart'][$prod_id])) {
                    $_SESSION['cart'][$prod_id]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$prod_id] = ['quantity' => $quantity, 'name' => $row['prod_name'], 'price' => $row['prod_price'], 'image' => $row['prod_img']];
                }
            }
        }
    }
    
    if (isset($_POST['remove_product']) && isset($_POST['remove_quantity'])) {
        $remove_product = $_POST['remove_product'];
        $remove_quantity = intval($_POST['remove_quantity']);
        
        if (isset($_SESSION['cart'][$remove_product])) {
            if ($_SESSION['cart'][$remove_product]['quantity'] > $remove_quantity) {
                $_SESSION['cart'][$remove_product]['quantity'] -= $remove_quantity;
            } else {
                unset($_SESSION['cart'][$remove_product]);
            }
        }
    }
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Order Form</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM rpos_products";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-3 product-card">
                <div class="card text-center">
                    <img src="<?php echo $row['prod_img']; ?>" class="card-img-top" alt="<?php echo $row['prod_name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['prod_name']; ?></h5>
                        <p>Price: $<?php echo $row['prod_price']; ?></p>
                        <form method="POST">
                            <input type="hidden" name="prod_id" value="<?php echo $row['prod_id']; ?>">
                            <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#cartModal">
        View Cart
    </button>

    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Shopping Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; foreach ($_SESSION['cart'] as $id => $details): ?>
                                <tr>
                                    <td><img src="<?php echo $details['image']; ?>" width="50" alt="<?php echo $details['name']; ?>"></td>
                                    <td><?php echo $details['name']; ?></td>
                                    <td>$<?php echo $details['price']; ?></td>
                                    <td><?php echo $details['quantity']; ?></td>
                                    <td>$<?php echo $details['quantity'] * $details['price']; ?></td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="remove_product" value="<?php echo $id; ?>">
                                            <input type="number" name="remove_quantity" value="1" min="1" max="<?php echo $details['quantity']; ?>" class="form-control mb-2 d-inline" style="width: 60px;">
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php $total += $details['quantity'] * $details['price']; endforeach; ?>
                        </tbody>
                    </table>
                    <h4 class="text-end">Total: $<?php echo $total; ?></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
