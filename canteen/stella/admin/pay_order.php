<?php
session_start();

include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['pay'])) {
  //Prevent Posting Blank Values
  //Visit codeastro.com for more projects
  if (empty($_POST["pay_code"]) || empty($_POST["pay_amt"]) || empty($_POST['pay_method']) || empty($_POST['pay_ref']) || empty($_POST['paid_amount'])) {
    $err = "Blank Values Not Accepted";
  } else {

    $pay_code = $_POST['pay_code'];
    $pay_ref = $_POST['pay_ref'];
    $order_code = $_GET['order_code'];
    $customer_id = $_GET['customer_id'];
    $pay_amt = $_POST['pay_amt'];
    $pay_method = $_POST['pay_method'];
    $pay_id = $_POST['pay_id'];
    $paid_amount = $_POST['paid_amount'];
    $prod_img = $_FILES['prod_img']['name'];
    move_uploaded_file($_FILES["prod_img"]["tmp_name"], "assets/img/payments/" . $_FILES["prod_img"]["name"]);
    $order_status = $_GET['order_status'];

    $net = $paid_amount - $pay_amt;

    $total_rewards = number_format(($pay_amt * 0.01), 2, '.', '');


    if ($pay_method == 'Rewards') {

      $total_rewards = number_format(($pay_amt), 2, '.', '');

      $ret = "SELECT * FROM rpos_customers WHERE customer_id ='$customer_id' ";
      $stmt = $mysqli->prepare($ret);
      $stmt->execute();
      $res = $stmt->get_result();
      while ($reward = $res->fetch_object()) {
        $total = number_format(($reward->rewards), 2, '.', '');
      }

      if ($total_rewards > $total) {

        $err = "Your Rewards is not enough to process your request";

      } else {


        $total_gross = number_format(($total - $total_rewards), 2, '.', '');
        //Insert Captured information to a database table
        $postQuery = "INSERT INTO rpos_payments (pay_id, pay_code, order_code, customer_id, pay_amt, pay_method, pay_ref, pay_proof, paid_amount,net_amount) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $upQry = "UPDATE rpos_orders SET order_status =? WHERE order_code =?";
        $rewq = "UPDATE rpos_customers SET rewards=? WHERE customer_id=? ";

        $postStmt = $mysqli->prepare($postQuery);
        $upStmt = $mysqli->prepare($upQry);
        $rewqtmt = $mysqli->prepare($rewq);
        //bind paramaters

        $rc = $postStmt->bind_param('ssssssssss', $pay_id, $pay_code, $order_code, $customer_id, $pay_amt, $pay_method, $pay_ref, $prod_img, $paid_amount, $net);
        $rc = $upStmt->bind_param('ss', $order_status, $order_code);
        $rc = $rewqtmt->bind_param('ss', $total_gross, $customer_id);

        $postStmt->execute();
        $upStmt->execute();
        $rewqtmt->execute();
        //declare a varible which will be passed to alert function
        if ($upStmt && $postStmt) {
          $_SESSION['payment_success'] = true;
          header("Location: " . $_SERVER['REQUEST_URI']); // Refresh the form page
          exit;
        } else {
          $_SESSION['payment_error'] = "Please Try Again Or Try Later";
        }


      }

    } else {

      $total_rewards = number_format(($pay_amt * 0.01), 2, '.', '');

      $ret = "SELECT * FROM rpos_customers WHERE customer_id ='$customer_id' ";
      $stmt = $mysqli->prepare($ret);
      $stmt->execute();
      $res = $stmt->get_result();
      while ($reward = $res->fetch_object()) {

        $total = number_format(($reward->rewards + $total_rewards), 2, '.', '');

      }

      //Insert Captured information to a database table
      $postQuery = "INSERT INTO rpos_payments (pay_id, pay_code, order_code, customer_id, pay_amt, pay_method, pay_ref, pay_proof, paid_amount,net_amount) VALUES(?,?,?,?,?,?,?,?,?,?)";
      $upQry = "UPDATE rpos_orders SET order_status =? WHERE order_code =?";
      $rewq = "UPDATE rpos_customers SET rewards=? WHERE customer_id=? ";

      $postStmt = $mysqli->prepare($postQuery);
      $upStmt = $mysqli->prepare($upQry);
      $rewqtmt = $mysqli->prepare($rewq);
      //bind paramaters

      $rc = $postStmt->bind_param('ssssssssss', $pay_id, $pay_code, $order_code, $customer_id, $pay_amt, $pay_method, $pay_ref, $prod_img, $paid_amount, $net);
      $rc = $upStmt->bind_param('ss', $order_status, $order_code);
      $rc = $rewqtmt->bind_param('ss', $total_gross, $customer_id);

      $postStmt->execute();
      $upStmt->execute();
      $rewqtmt->execute();
      //declare a varible which will be passed to alert function
      if ($upStmt && $postStmt) {
        $_SESSION['payment_success'] = true;
        header("Location: " . $_SERVER['REQUEST_URI']); // Refresh the form page
        exit;
      } else {
        $_SESSION['payment_error'] = "Please Try Again Or Try Later";
      }


    }
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
    $order_code = $_GET['order_code'];
    $ret = "SELECT * FROM  rpos_orders WHERE order_code ='$order_code' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($order = $res->fetch_object()) {
      $total = ($order->prod_price);

      ?>

      <!-- Header -->
      <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;"
        class="header  pb-8 pt-5 pt-md-8">
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
                <h3>Please Fill All Fields</h3>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Payment ID</label>
                      <input type="text" name="pay_id" readonly value="<?php echo $payid; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Payment Code</label>
                      <input type="text" name="pay_code" value="<?php echo $mpesaCode; ?>" class="form-control" value="">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Amount (Php)</label>
                      <input type="text" name="pay_amt" readonly value="<?php echo $total; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Payment Method</label>
                      <select class="form-control" name="pay_method" id="pay_method" onchange="togglePaymentReference()">
                        <option selected>Cash</option>
                        <option>Gcash</option>
                        <option>Maya</option>
                        <option>Rewards</option>
                      </select>
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Payment Reference</label>
                      <input type="text" name="pay_ref" id="pay_ref" class="form-control"
                        placeholder="Enter Payment Reference Number">
                    </div>
                    <div class="col-md-6">
                      <label>Amount Paid(Php)</label>
                      <input type="text" name="paid_amount" id="paid_amount" value="" class="form-control">
                    </div>
                    <div class="col-md-6" style="display: none;">
                      <label>Proof Image</label>
                      <input type="file" name="prod_img" class="btn btn-outline-success form-control" value="">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6" style="margin-top:30px;">
                      <input type="submit" name="pay" value="Pay Order" class="btn btn-success" value="">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <script>
          function togglePaymentReference() {
            var paymentMethod = document.getElementById("pay_method").value;
            var paymentRef = document.getElementById("pay_ref");

            if (paymentMethod === "Cash" || paymentMethod === "Rewards") {
              paymentRef.value = "N/A";
              paymentRef.readOnly = true;
            } else {
              paymentRef.value = "";
              paymentRef.readOnly = false;
            }
          }

          document.addEventListener("DOMContentLoaded", togglePaymentReference);
        </script>
        <!-- Footer -->
        <?php
        require_once('partials/_footer.php');
        ?>
      </div>
    </div>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    }
    ?>
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php if (isset($_SESSION['payment_success'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        Swal.fire({
          icon: 'success',
          title: 'Payment Successful!',
          text: 'Redirecting to payments...',
          confirmButtonColor: '#28a745',
          timer: 2000,
          timerProgressBar: true,
          showConfirmButton: false
        }).then((result) => {
          window.location.href = 'payments.php';
        });
      });
    </script>
    <?php unset($_SESSION['payment_success']); ?>
  <?php endif; ?>


</body>

</html>