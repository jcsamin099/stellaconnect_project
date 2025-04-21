<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();


require_once('partials/_head.php');

?>
<style>
        .card-container {
            width: 400px;
            height: 250px;
            background: linear-gradient(135deg,rgb(231, 86, 8),rgb(95, 14, 14));
            border-radius: 15px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .card-header2 {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card-chip {
            position: absolute;
            top: 60px;
            left: 20px;
            width: 50px;
            height: 35px;
            background-color: #c4c4c4;
            border-radius: 5px;
        }

        .card-number {
            position: absolute;
            top: 120px;
            left: 20px;
            font-size: 1.4rem;
            letter-spacing: 3px;
        }

        .card-holder {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }

        .card-holder span {
            display: block;
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .card-holder-name {
            font-size: 1rem;
            font-weight: bold;
            margin-top: 5px;
        }

        .card-expiry {
            position: absolute;
            bottom: 20px;
            right: 20px;
            text-align: right;
        }

        .card-expiry span {
            display: block;
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .card-expiry-date {
            font-size: 1rem;
            font-weight: bold;
            margin-top: 5px;
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
      <?php
        $customer_id = $_SESSION['customer_id'];
        //$login_id = $_SESSION['login_id'];
        $ret = "SELECT * FROM  rpos_customers  WHERE customer_id = '$customer_id'";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($customer = $res->fetch_object()) {

        
        ?>
    <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 300px; background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
                <!-- Mask -->
                <span class="mask  opacity-8" style="background-color:#800000;"></span>
                <!-- Header container -->
                <div class="container-fluid d-flex align-items-center">
                    <div class="row">
                        <div class="col-lg-8 col-md-11">
                            <h1 class=" text-white">Hello! <?php echo $customer->customer_name; ?></h1>
                            <p class="text-white mt-0 mb-5">This is your Rewards page where you can track your reward points</p>
                        </div>
                    </div>
                </div>
        </div>
            <!-- Page content -->
            <div class="container-fluid mt--8">
                <div class="row">
                    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                        <div class="card card-profile shadow">
                            <div class="row justify-content-center">
                                <div class="col-lg-3 order-lg-2">
                                    <div class="card-profile-image">
                                        <a href="#">
                                            <img src="../admin/assets/img/theme/user-a-min.png" class="rounded-circle">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                                <div class="d-flex justify-content-between">
                                </div>
                            </div>
                            <div class="card-body pt-0 pt-md-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                            <div>
                                            </div>
                                            <div>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left" >
                                    <h2>
                                        <?php echo $customer->customer_name; ?></span>
                                    </h2>
                                    <div class="h4 font-weight-300">
                                        <i class="fas fa-envelope mr-2"> </i>Email: <?php echo $customer->customer_email; ?>
                                    </div>
                                    <div class="h4 font-weight-300">
                                        <i class="fas fa-phone mr-2"></i> Phone: <?php echo $customer->customer_phoneno; ?>
                                    </div>
                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 order-xl-1">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">My account</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                            <div class="card-container">
                                <div class="card-header2">Customer's Reward Card</div>
                                    <div class="card-chip"></div>
                                         <div class="card-number"><?php echo $customer->customer_id; ?></div>
                                                 <div class="card-holder">
                                                 <span>Stella's Rewards </span>
                                        <div class="card-holder-name"> <?php echo $customer->customer_name; ?></div>
                                    </div>
                         <div class="card-expiry">
                             <span>Available Points</span>
                                <div class="card-expiry-date"> <?php echo $customer->rewards; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
      <!-- Footer -->
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>