<?php
session_start();
include('admin/config/config.php');
//login 
if (isset($_POST['login'])) {

  $admin_email = $_POST['admin_email'];
  $admin_password = sha1(md5($_POST['admin_password']));
  $login = $_POST['logtype'];  //double encrypt to increase security
  if($login == 1){
  $stmt = $mysqli->prepare("SELECT admin_email, admin_password, admin_id  FROM   rpos_admin WHERE (admin_email =? AND admin_password =?)"); //sql to log in user
  $stmt->bind_param('ss',  $admin_email, $admin_password); //bind fetched parameters
  $stmt->execute(); //execute bind 
  $stmt->bind_result($admin_email, $admin_password, $admin_id); //bind result
  $rs = $stmt->fetch();
  $_SESSION['admin_id'] = $admin_id;
  if ($rs) {
    //if its sucessfull
	//Visit codeastro.com for more projects
    header("location:admin/dashboard.php");
  } else {
    $err = "Invalid Username Or Password";
  }
}else{
    $stmt = $mysqli->prepare("SELECT customer_email, customer_password, customer_id  FROM  rpos_customers WHERE (customer_email =? AND customer_password =?)"); //sql to log in user
    $stmt->bind_param('ss',  $admin_email, $admin_password); //bind fetched parameters
    $stmt->execute(); //execute bind 
    $stmt->bind_result($customer_email, $customer_password, $customer_id); //bind result
    $rs = $stmt->fetch();
    $_SESSION['customer_id'] = $customer_id;
    if ($rs) {
        //if its sucessfull
        header("location:customer/dashboard.php");
    } else {
        $err = "Incorrect Authentication Credentials ";
    }
}
}
require_once('partials/_head.php');
?>
<style>

</style>
<body  class="bg-dark" style="background-image:url('admin/assets/img/theme/stella.jpg');background-size:cover;">
<div class="">
<div class="main-content">
    <div class="header opacity-8 py-5">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
            <h1 class="text-yellow"><img alt="Image paceholder" src="admin/assets/img/theme/CICLOGO.png" style="width:100px;height:100px;border:2px solid #fff;border-radius:180px;"></h1>
              <h1 class="" style="color:#800000;">Canteen Management System</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5" >
      <div class="row justify-content-center">
        <div class="justify-content-center  col-lg-5 col-md-7" style="background-color:rgba(255,184,28,0.8);">
       <br>
       <br>
       <h4>Admin Login</h4>
              <form method="post" role="form">
              <div class="form-group mb-3" style="display: none;">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                   <select name="logtype" id="logtype" class="form-control" required>   
                    <option value="1" class="">Admin</option>
                   </select>
                  </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" required name="admin_email" placeholder="Email" type="email">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" required name="admin_password" placeholder="Password" type="password">
                  </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-white">Remember Me</span>
                  </label>
                </div>
                <div class="text-center">
                  <button type="submit" name="login" class="btn btn-primary my-4">Log In</button>
                  <a href="customer/create_account.php" class=" btn btn-success pull-right">Create Account</a>
                </div>
              </form>

           
      
          <div class="row mt-3">
            <div class="col-6">
              <!-- <a href="forgot_pwd.php" class="text-light"><small>Forgot password?</small></a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->

  <!-- Argon Scripts -->

</body>

</html>