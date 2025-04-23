<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>

<?php

// Check if ID is set in the URL and process only if it's available
if (isset($_GET['ID'])) {
    // Check if the confirmation has already been processed
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        // If confirmed, update the order status in the database
        $query = $mysqli->query("UPDATE rpos_orders SET order_status = 'Verified' WHERE order_id = '" . $_GET['ID'] . "'");

        if ($query) {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Order status updated successfully!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'orders_reports.php';
                    });
                });
            </script>";
        }
    } else {
        // If confirmation isn't set, show the confirmation alert
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to mark this order as Verified.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, verify it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, redirect to the same page with a confirm parameter
                        window.location.href = 'orders_reports.php?ID=" . $_GET['ID'] . "&confirm=true';
                    }
                });
            });
        </script>";
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;"
            class="header pb-8 pt-5 pt-md-8">
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
                            Orders Records
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-yellow" scope="col">Code</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Payment Reference</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM rpos_orders ORDER BY `created_at` DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                        $total = $order->prod_price;

                                        // Fetch payment method and reference in one query
                                        $query = $mysqli->prepare("SELECT pay_method, pay_ref FROM rpos_payments WHERE order_code = ? ORDER BY created_at DESC LIMIT 1");
                                        $query->bind_param("s", $order->order_code);
                                        $query->execute();
                                        $payment_result = $query->get_result();

                                        $pay_method = "N/A";
                                        $pay_ref = "N/A";

                                        if ($payment_result->num_rows > 0) {
                                            $payment = $payment_result->fetch_object();
                                            $pay_method = $payment->pay_method;
                                            $pay_ref = $payment->pay_ref;
                                        }
                                        ?>
                                        <tr>
                                            <th class="text-yellow" scope="row"><?php echo $order->order_code; ?></th>
                                            <td><?php echo $order->customer_name; ?></td>

                                            <!-- Payment Method -->
                                            <td><?php echo $pay_method; ?></td>

                                            <!-- Payment Reference -->
                                            <td><?php echo $pay_ref; ?></td>

                                            <td><?php echo number_format($total, 2); ?></td>

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
                                            <td><?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#details<?php echo $order->order_id; ?>">View</button>

                                                <?php if ($order->order_status == 'Paid') { ?>
                                                    <a href="orders_reports.php?ID=<?= $order->order_id ?>"
                                                        class="btn btn-info">Paid</a>
                                                <?php } ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="details<?php echo $order->order_id; ?>"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <center>
                                                                    <h4 class="modal-title" id="exampleModal">Order Full
                                                                        Details</h4>
                                                                </center>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <h5>Customer:
                                                                        <b><?php echo $order->customer_name; ?></b>
                                                                        <span class="text-right" style="float:right;">
                                                                            <?php echo date('M d, Y h:i A', strtotime($order->created_at)) ?>
                                                                        </span>
                                                                    </h5>
                                                                    <table class="table align-items-center table-flush">
                                                                        <thead>
                                                                            <th>Product Name</th>
                                                                            <th>Price</th>
                                                                            <th>Purchase Quantity</th>
                                                                            <th>Subtotal</th>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $sql = "SELECT * FROM purchase_detail LEFT JOIN rpos_products ON rpos_products.prod_id = purchase_detail.prod_id WHERE order_id = '" . $order->order_id . "'";
                                                                            $dquery = $mysqli->query($sql);
                                                                            while ($drow = $dquery->fetch_array()) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?php echo $drow['prod_name']; ?></td>
                                                                                    <td class="text-right">&#8369;
                                                                                        <?php echo number_format($drow['prod_price'], 2); ?>
                                                                                    </td>
                                                                                    <td><?php echo $drow['prod_qty']; ?></td>
                                                                                    <td class="text-right">&#8369;
                                                                                        <?php
                                                                                        $subt = $drow['prod_price'] * $drow['prod_qty'];
                                                                                        echo number_format($subt, 2);
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td colspan="3" class="text-right">
                                                                                    <b>TOTAL</b></td>
                                                                                <td class="text-right">&#8369;
                                                                                    <?php echo number_format($order->prod_price, 2); ?>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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