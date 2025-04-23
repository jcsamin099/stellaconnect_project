<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
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
        <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;"
            class="header  pb-8 pt-5 pt-md-8">
            <span class="mask  opacity-8"
                style="background-color:#800000;position:absolute;top:0;left:0;height:100%;width:100%;"></span>
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
                            Orders Records
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-yellow" scope="col">Code</th>
                                        <th scope="col">Customer</th>
                                        
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Status</th>
                                        <th class="text-yellow" scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php
    $customer_id = $_SESSION['customer_id'];
    $ret = "SELECT * FROM rpos_orders WHERE customer_id = ? ORDER BY created_at DESC";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param("s", $customer_id);
    $stmt->execute();

    $res = $stmt->get_result();
    while ($order = $res->fetch_object()) {
    ?>
    <tr>
        <th class="text-yellow" scope="row"><?php echo $order->order_code; ?></th>
        <td><?php echo $order->customer_name; ?></td>
        <!-- Removed Product column -->
        <td><?php echo $order->prod_price; ?></td>  <!-- Keep the price column -->
        <td>
            <?php
            if ($order->order_status == '') {
                echo "<span class='badge badge-danger'>Not Paid</span>";
            } elseif ($order->order_status == 'Paid') {
                echo "<span class='badge badge-success'>$order->order_status</span>";
            } else {
                echo "<span class='badge badge-info'>$order->order_status</span>";
            }
            ?>
        </td>
        <td class="text-yellow">
            <?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?>
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
</body>

</html>