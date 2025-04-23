<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

$deleted = false;
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $adn = "DELETE FROM rpos_products WHERE prod_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $stmt->close();
  $deleted = true;
}
require_once('partials/_head.php');
?>

<style>  
  .custom-control-label {
    display: flex;
    justify-content: space-between;
  }

  .custom-control-label .status-label {
    font-size: 14px;
    padding: 5px;
    font-weight: bold;
  }

  .custom-control-input:checked + .custom-control-label .status-label {
    color: #007bff; /* Blue color for "Available" */
  }

  .custom-control-input:not(:checked) + .custom-control-label .status-label {
    color: #dc3545; /* Red color for "Not Available" */
  }
</style>


<body>
  <!-- Sidenav -->
  <?php require_once('partials/_sidebar.php'); ?>

  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php require_once('partials/_topnav.php'); ?>

    <!-- Header -->
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
      <span class="mask opacity-8" style="background-color:#800000;"></span>
      <div class="container-fluid">
        <div class="header-body"></div>
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
                <i class="fas fa-utensils"></i> Add New Product
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
                        $imgSrc = $prod->prod_img ? "assets/img/products/$prod->prod_img" : "assets/img/products/default.jpg";
                        echo "<img src='$imgSrc' height='60' width='60' class='img-thumbnail'>";
                        ?>
                      </td>
                      <td><?php echo $prod->prod_code; ?></td>
                      <td><?php echo $prod->prod_name; ?></td>
                      <td><?php echo $prod->prod_price; ?></td>
                      <td>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="prodStatusSwitch<?php echo $prod->prod_id; ?>" 
                                 data-prod-id="<?php echo $prod->prod_id; ?>" name="status" value="0"
                                 <?php echo ($prod->status == 0) ? 'checked' : ''; ?>>
                          <label class="custom-control-label" for="prodStatusSwitch<?php echo $prod->prod_id; ?>">
                            <span class="status-label"><?php echo ($prod->status == 0) ? 'Available' : 'Not Available'; ?></span>
                          </label>
                        </div>
                      </td>
                      <td>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?php echo $prod->prod_id; ?>')">
                          <i class="fas fa-trash"></i> Delete
                        </button>
                        <a href="update_product.php?update=<?php echo $prod->prod_id; ?>">
                          <button class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Update
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
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>

  <!-- Argon Scripts -->
  <?php require_once('partials/_scripts.php'); ?>

  <!-- SweetAlert2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function confirmDelete(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this product?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'products.php?delete=' + id;
        }
      });
    }

    $(document).ready(function () {
      $('.custom-control-input').change(function () {
        var checkbox = $(this);
        var prod_id = checkbox.data('prod-id');
        var new_status = checkbox.prop('checked') ? '0' : '1'; // 0 = Available, 1 = Not Available

        $.ajax({
          url: 'update_status.php',
          method: 'POST',
          data: { prod_id: prod_id, status: new_status },
          success: function (response) {
            if (typeof response === "string") {
              response = JSON.parse(response); // Ensure it's an object
            }

            if (response.success) {

              // Find the corresponding label and update the text
              var labelSpan = checkbox.closest('.custom-control').find('.status-label');
              labelSpan.text(new_status === '1' ? 'Not Available' : 'Available');

              Swal.fire({
                icon: 'success',
                title: 'Status Updated!',
                text: 'Product status has been updated successfully.',
                confirmButtonColor: '#3085d6'
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Update Failed!',
                text: response.message || 'There was an error updating the product status.',
                confirmButtonColor: '#d33'
              });
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'An error occurred while updating the status.',
              confirmButtonColor: '#d33'
            });
            // Revert checkbox state
            checkbox.prop('checked', !checkbox.prop('checked'));
          }
        });
      });
    });
  </script>
</body>
</html>
