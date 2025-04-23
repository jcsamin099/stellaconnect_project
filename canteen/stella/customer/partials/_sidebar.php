<?php
$customer_id = $_SESSION['customer_id'];
$ret = "SELECT * FROM  rpos_customers  WHERE customer_id = '$customer_id'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($customer = $res->fetch_object()) {
?>
<style>
  /* Only target customer sidebar links */
  .navbar-vertical .navbar-nav .nav-link {
    color: #000 !important;
    transition: background 0.3s, color 0.3s;
  }

  .navbar-vertical .navbar-nav .nav-link:hover {
    background-color: #f2f2f2;
    border-radius: 5px;
  }

  .navbar-vertical .navbar-nav .nav-link.active {
    background-color: #647C90 !important;
    color: #fff !important;
    font-weight: bold;
    border-radius: 5px;
  }

  .navbar-brand,
  .navbar-brand i {
    color: #000 !important;
  }
</style>

<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
  <div class="container-fluid">
    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Brand -->
    <a class="navbar-brand pt-0" href="dashboard.php">
      <img alt="Image placeholder" src="../admin/assets/img/theme/CICLOGO.png"> <i>Stella's Canteen</i>
    </a>

    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item bg-white" style="margin-top:10px;">
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php') echo 'active'; ?>" href="dashboard.php">
            <i class="ni ni-tv-2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item bg-white" style="margin-top:10px;">
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'change_profile.php') echo 'active'; ?>" href="change_profile.php">
            <i class="fas fa-users"></i> My Profile
          </a>
        </li>
        <li class="nav-item bg-white" style="margin-top:10px;">
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'rewards.php') echo 'active'; ?>" href="rewards.php">
            <i class="ni ni-credit-card"></i> Rewards
          </a>
        </li>
        <li class="nav-item bg-white" style="margin-top:10px;">
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'orders.php') echo 'active'; ?>" href="orders.php">
            <i class="ni ni-cart"></i> Make Order
          </a>
        </li>
        <li class="nav-item bg-white" style="margin-top:10px;">
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'payments.php') echo 'active'; ?>" href="payments.php">
            <i class="ni ni-credit-card"></i> Payments
          </a>
        </li>
      </ul>
      
      <!-- Divider -->
      <hr class="my-3">
      <!-- Heading -->
      <h6 class="navbar-heading text-muted">Reporting</h6>
      <ul class="navbar-nav mb-md-3">
        <li class="nav-item bg-white" style="margin-top:10px;">
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'orders_reports.php') echo 'active'; ?>" href="orders_reports.php">
            <i class="fas fa-shopping-basket"></i> My Orders
          </a>
        </li>
        <li class="nav-item bg-white" style="margin-top:10px;">
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'payments_reports.php') echo 'active'; ?>" href="payments_reports.php">
            <i class="fas fa-funnel-dollar"></i> Payments Method
          </a>
        </li>
      </ul>

      <!-- Divider -->
      <hr class="my-3">
      <!-- Log Out -->
      <ul class="navbar-nav mb-md-3">
        <li class="nav-item bg-white" style="margin-top:10px;">
          <a class="nav-link text-red" href="logout.php">
            <i class="fas fa-sign-out-alt text-danger"></i> Log Out
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php } ?>
