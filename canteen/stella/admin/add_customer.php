<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');
check_login();

// Add Customer
if (isset($_POST['addCustomer'])) {
  if (empty($_POST["customer_phoneno"]) || empty($_POST["customer_name"]) || empty($_POST['customer_email']) || empty($_POST['customer_password'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $customer_name = $_POST['customer_name'];
    $customer_phoneno = $_POST['customer_phoneno'];
    $customer_email = $_POST['customer_email'];
    $customer_password = sha1(md5($_POST['customer_password']));
    $customer_id = $_POST['customer_id'];
    $customer_role = $_POST['role'];

    $postQuery = "INSERT INTO rpos_customers (customer_id, customer_name, customer_phoneno, customer_email, customer_password, role) VALUES(?,?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    $rc = $postStmt->bind_param('ssssss', $customer_id, $customer_name, $customer_phoneno, $customer_email, $customer_password, $customer_role);
    $postStmt->execute();

    if ($postStmt) {
      $success = true; // Used to trigger Swal
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php require_once('partials/_sidebar.php'); ?>

  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php require_once('partials/_topnav.php'); ?>

    <!-- Header -->
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;"
      class="header pb-8 pt-5 pt-md-8">
      <span class="mask opacity-8" style="background-color:#800000;"></span>
      <div class="container-fluid">
        <div class="header-body"></div>
      </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h1 class="text-2xl"><strong>Create New User</strong></h1>
            </div>
            <div class="card-body">
              <h3>Please Fill All Fields</h3>
              <form method="POST" id="addCustomerForm">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" required placeholder="Enter Name">
                    <input type="hidden" name="customer_id" value="<?php echo $cus_id; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Customer Phone Number</label>
                    <input type="text" name="customer_phoneno" class="form-control" required
                      placeholder="Enter Phone Number">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Customer Email</label>
                    <input type="email" name="customer_email" class="form-control" required placeholder="Enter Email">
                  </div>
                  <div class="col-md-6">
                    <label>Customer Password</label>
                    <input type="password" name="customer_password" class="form-control" required
                      placeholder="Enter Password">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                      <option value="">Select Customer Role</option>
                      <option value="0">Student</option>
                      <option value="1">Faculty</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addCustomer" value="Add Customer" class="btn btn-success">
                  </div>
                </div>
              </form>
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

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- SweetAlert Trigger -->
  <?php if (isset($success) && $success): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Customer Added!',
        text: 'The new customer has been successfully registered.',
        allowOutsideClick: false,
        showEscapeButton: false, 
        showCancelButton: true,
        confirmButtonText: 'Go to Customers', // Confirm button text
        cancelButtonText: 'Stay Here', // Cancel button text
        reverseButtons: false // This reverses the buttons to keep "Yes" on the left
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'The user created successfully!',
            allowOutsideClick: false,
            confirmButtonText: 'OK'
          }).then(() => {
            window.location.href = 'customes.php'; // Make sure this is the correct page
          });
        }
      });
    </script>
<?php endif; ?>


  <?php if (isset($err)): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?= $err ?>',
        allowOutsideClick: false,
        allowEscapeClick: false,
        confirmButtonText: 'Retry'
      });
    </script>
  <?php endif; ?>
</body>

</html>