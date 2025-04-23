<?php
session_start();
include('config/config.php');
include('config/code-generator.php');
include('config/checklogin.php');
check_login();

include('config/config.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product']) && isset($_POST['quantity']) && isset($_POST['price'])) {
        $product = $_POST['product'];
        $product_id = $_POST['prod_id'];
         $image =  $_POST['image'];
        $quantity = intval($_POST['quantity']);
        $price = floatval($_POST['price']);
        
        if ($quantity > 0) {
            if (isset($_SESSION['cart'][$product])) {
                $_SESSION['cart'][$product]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$product] = ['quantity' => $quantity,'product_id' => $product_id, 'price' => $price, 'image' => $image];
            }
        }
    }
    
    if (isset($_POST['removed'])) {
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

if(isset($_GET['success_id'])){
    if ($_GET['success_id'] == 1) {
        $success = "Order Submitted" && header("refresh:1; url=payments.php");
      } else {
        $err = "Please Try Again Or Try Later";
      }	
}

require_once('partials/_head.php');
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function filterProducts() {
            let input = document.getElementById('searchBox').value.toLowerCase();
            let productCards = document.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                let title = card.querySelector('.card-title').innerText.toLowerCase();
                if (title.includes(input)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }
    </script>
     <script>
        let currentPage = 1;
        const productsPerPage = 12;
        
        function showPage(page) {
            let productCards = document.querySelectorAll('.product-card');
            let totalProducts = productCards.length;
            let totalPages = Math.ceil(totalProducts / productsPerPage);
            
            if (page < 1) page = 1;
            if (page > totalPages) page = totalPages;
            
            currentPage = page;
            
            productCards.forEach((card, index) => {
                if (index >= (page - 1) * productsPerPage && index < page * productsPerPage) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
            updatePagination(totalPages);
        }
        
        function updatePagination(totalPages) {
            let paginationContainer = document.getElementById('pagination');
            paginationContainer.innerHTML = '';
            
            for (let i = 1; i <= totalPages; i++) {
                let pageItem = document.createElement('li');
                pageItem.className = `page-item ${i === currentPage ? 'active' : ''}`;
                let pageLink = document.createElement('a');
                pageLink.className = 'page-link';
                pageLink.href = '#';
                pageLink.innerText = i;
                pageLink.onclick = function() {
                    showPage(i);
                    return false;
                };
                pageItem.appendChild(pageLink);
                paginationContainer.appendChild(pageItem);
            }
        }
        
        window.onload = function() {
            showPage(1);
        };
    </script>
<style>
    h2 {
        font-family: 'Arial', sans-serif;
        color: #343a40;
    }
    .table-responsive {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem;
    }
</style>
<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
    <span class="mask  opacity-8" style="background-color:#800000;"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
            <div class="container mt-5">
    <div class="container-fluid">
    <h2 class="text-center">Order Form</h2>
        <div class="row">
            <div class="col-sm-4">
            <input type="text" id="searchBox" onkeyup="filterProducts()" class="form-control mb-3" placeholder="Search for products...">
            </div>
            <div class="col-sm-6">
            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#cartModal" style="float:right;">
        View Cart
    </button>

            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" style="max-height: 500px; overflow-y: auto;">

    <style>
.card.text-center {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.card-img-top {
    height: 180px;
    object-fit: cover;
}
</style>

<?php
$sql = "SELECT * FROM rpos_products";
$result = $mysqli->query($sql);
while ($product = $result->fetch_assoc()): ?>
    <div class="col-md-3 product-card mb-4">
        <div class="card text-center h-100">
            <?php if($product['prod_img']) { ?>
                <img src="../admin/assets/img/products/<?php echo $product['prod_img']; ?>" class="card-img-top" alt="<?php echo $product['prod_name']; ?>">
            <?php } else { ?>
                <img src='../admin/assets/img/products/default.jpg' class="card-img-top">
            <?php } ?>
            <div class="card-body d-flex flex-column">
                <div class="mb-2">
                    <h5 class="card-title"><?php echo $product['prod_name']; ?></h5>
                    <p>Price: ₱ <?php echo $product['prod_price']; ?></p>
                </div>

                <form method="POST" onsubmit="return addToCart(this);" class="mt-auto">
                    <input type="hidden" name="prod_id" value="<?php echo $product['prod_id']; ?>">
                    <input type="hidden" name="product" value="<?php echo $product['prod_name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $product['prod_price']; ?>">
                    <input type="hidden" name="image" value="<?php echo $product['prod_img']; ?>">

                    <div class="input-group mb-2" style="max-width: 200px; margin: 0 auto;">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary minus-btn" type="button">-</button>
                        </div>
                        <input type="number" name="quantity" class="form-control text-center quantity-input" value="1" min="1">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
<?php endwhile; ?>

            
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
    </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
  
    </div>
  </div>

  
  <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Shopping Cart</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"> x </button>
            </div>
            <div class="modal-body">
                <form action="function.php" method="POST">
                    <div class="row">
                        <div class="col-md-3">
                        <?php
                                        //Load All Customers
                                        $customer_id = $_SESSION['customer_id'];
                                        $ret = "SELECT * FROM  rpos_customers WHERE customer_id = '$customer_id' ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($cust = $res->fetch_object()) {
                                        ?>
                                            <input class="form-control" readonly name="customer_name" value="<?php echo $cust->customer_name; ?>">
                                        <?php } ?>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="customer_id" value="<?= $customer_id ?>" readonly id="customerID" class="form-control">
                            <input type="hidden" name="order_id" value="<?php echo $orderid; ?>" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="order_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <input type="time" name="pick_up" value="" class="form-control">
                        </div>
                        <div class="col-sm-2">
                        <input type="hidden" name="order_id" value="<?= $orderid ?>">
                        <input type="submit" name="sub" class="btn btn-primary" value="Check Out">
                        </div>
                    </div>
                    </form>
                    <br>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0;
                            foreach ($_SESSION['cart'] as $item => $details) : ?>
                                <tr>
                                    <td><?php echo $details['product_id']; ?></td>
                                    <td>₱ <?php echo $details['price']; ?></td>
                                    <td><?php echo $details['quantity']; ?></td>
                                    <td>₱ <?php echo number_format($details['quantity'] * $details['price'], 2); ?></td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="remove_product" value="<?php echo $item; ?>">
                                            <input type="number" name="remove_quantity" value="1" min="1" max="<?php echo $details['quantity']; ?>" class="form-control mb-2 d-inline" style="width: 60px;">
                                            <button type="submit" name="removed" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php $total += $details['quantity'] * $details['price'];
                            endforeach; ?>
                        </tbody>
                    </table>
                    <h4 class="text-right">Total: ₱ <?php echo number_format($total, 2); ?></h4>
              
            </div>
            <div class="modal-footer">
          
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
           
        </div>
    </div>
</div>

<script>
            function addToCart(form) {
                var productName = form.querySelector("input[name='product']").value;
                var quantity = form.querySelector("input[name='quantity']").value;

                // SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: productName + " (x" + quantity + ") will be added to your cart.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, add it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show success message before submitting the form
                        Swal.fire({
                            title: 'Success!',
                            text: productName + " (x" + quantity + ") has been added to your cart.",
                            icon: 'success',
                            timer: 3000, // Keep success message for 3 seconds
                            showConfirmButton: false, // Hide the confirm button
                        }).then(() => {
                            // Submit the form after the SweetAlert finishes
                            form.submit();
                        });
                    } else {
                        // If the user cancels, show the cancel message
                        Swal.fire(
                            'Cancelled',
                            'Your item was not added to the cart.',
                            'error'
                        );
                    }
                });

                return false; // Prevent form submission here, as it's handled after confirmation
            }

            
        </script>

  <?php
      require_once('partials/_footer.php');
      ?>
  <!-- Argon Scripts -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <script>
$(document).ready(function() {
    $(".plus-btn").click(function() {
        let input = $(this).closest(".input-group").find(".quantity-input");
        let currentValue = parseInt(input.val());
        input.val(currentValue + 1);
    });

    $(".minus-btn").click(function() {
        let input = $(this).closest(".input-group").find(".quantity-input");
        let currentValue = parseInt(input.val());
        if (currentValue > 1) { // Prevent going below min value
            input.val(currentValue - 1);
        }
    });
});
</script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <!-- Responsive DataTables JS -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

</body>

</html>