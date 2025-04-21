<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $adn = "DELETE FROM rpos_products WHERE prod_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $stmt->close();
  if ($stmt) {
    $success = "Deleted Successfully";
  } else {
    $err = "Try Again Later";
  }
}
require_once('partials/_head.php');
?>

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
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
      <span class="mask opacity-8" style="background-color:#800000;"></span>
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
              <a href="add_product.php" class="btn btn-outline-warning">
                <i class="fas fa-utensils"></i>
                Add New Product
              </a>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM rpos_products";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td>
                        <?php
                        // Check if the product has an image, otherwise use the default image
                        if ($prod->prod_img) {
                          echo "<img src='assets/img/products/$prod->prod_img' style='height: 60px; width: 60px; object-fit: cover;' class='img-thumbnail'>";
                        } else {
                          echo "<img src='assets/img/products/default.jpg' style='height: 60px; width: 60px; object-fit: cover;' class='img-thumbnail'>";
                        }
                        ?>
                      </td>
                      <td><?php echo $prod->prod_code; ?></td>
                      <td><?php echo $prod->prod_name; ?></td>
                      <td><?php echo $prod->prod_price; ?></td>
                      <td>
                        <?php
                        if ($prod->status == '1') {
                          echo "<span class='badge badge-danger'>Not Available</span>";
                        } else {
                          echo "<span class='badge badge-primary'>Available</span>";
                        }
                        ?>
                      </td>
                      <td>
                        <a href="products.php?delete=<?php echo $prod->prod_id; ?>" 
                           onclick="return confirm('Are you sure you want to delete this product?');">
                          <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                          </button>
                        </a>
                        <a href="update_product.php?update=<?php echo $prod->prod_id; ?>">
                          <button class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                            Update
                          </button>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
      ?>
    </div>
  </div>

  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>

  <!-- JavaScript for Quantity Adjustment -->
  <script>
    function adjustQuantity(action) {
      let qtyInput = document.getElementById('quantity');
      let currentQty = parseInt(qtyInput.value);

      if (action === 'increase') {
        currentQty += 1;  // Increase quantity
      } else if (action === 'decrease' && currentQty > 1) {
        currentQty -= 1;  // Decrease quantity (minimum value 1)
      }

      qtyInput.value = currentQty; // Update input field
    }
  </script>
</body>
</html>
