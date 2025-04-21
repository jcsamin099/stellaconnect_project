<?php
$admin_id = $_SESSION['admin_id'];
$ret = "SELECT * FROM  rpos_admin  WHERE admin_id = '$admin_id'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($admin = $res->fetch_object()) {
  ?>
  <style>
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
  </style>

  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Brand -->
      <a class="navbar-brand pt-0" href="dashboard.php">
        <img alt="Logo" src="assets/img/theme/CICLOGO.png"> <i>Stella's Canteen</i>
      </a>

      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'dashboard.php')
              echo 'active'; ?>"
              href="dashboard.php">
              <i class="ni ni-tv-2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'customes.php')
              echo 'active'; ?>"
              href="customes.php">
              <i class="fas fa-users"></i> Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'products.php')
              echo 'active'; ?>"
              href="products.php">
              <i class="ni ni-bullet-list-67"></i> Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'orders.php')
              echo 'active'; ?>"
              href="orders.php">
              <i class="ni ni-cart"></i> Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'payments.php')
              echo 'active'; ?>"
              href="payments.php">
              <i class="ni ni-credit-card"></i> Payments
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'receipts.php')
              echo 'active'; ?>"
              href="receipts.php">
              <i class="fas fa-file-invoice-dollar"></i> Receipts
            </a>
          </li>
        </ul>

        <!-- Divider -->
        <hr class="my-3">
        <h6 class="navbar-heading text-muted">Reporting</h6>

        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'orders_reports.php')
              echo 'active'; ?>"
              href="orders_reports.php">
              <i class="fas fa-shopping-basket"></i> Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'payments_reports.php')
              echo 'active'; ?>"
              href="payments_reports.php">
              <i class="fas fa-funnel-dollar"></i> Payments
            </a>
          </li>
        </ul>

        <hr class="my-3">
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="fas fa-sign-out-alt text-danger"></i> Log Out
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<?php } ?>