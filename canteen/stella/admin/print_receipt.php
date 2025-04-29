<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="MartDevelopers Inc">
    <title>Stella's Canteen</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/img/icons/site.webmanifest">
    <link rel="mask-icon" href="assets/img/icons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="assets/css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/jquery.js"></script>
    <style>
        body {
            margin-top: 20px;
        }
    </style>
</head>
</style>
<?php
$order_code = $_GET['order_code'];
$ret = "SELECT * FROM  rpos_orders INNER JOIN rpos_payments ON rpos_orders.order_code = rpos_payments.order_code  WHERE rpos_orders.order_code = '$order_code'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($order = $res->fetch_object()) {
    $total = ($order->prod_price * $order->prod_qty);

    ?>

    <body>
        <div class="container">
            <div class="row">
                <div id="Receipt" class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <address>
                                <strong>Stella's Canteen</strong>
                                <br>
                                127-0-0-1
                                <br>
                                Cabanatuan City
                                <br>
                                (+000) 9999999999
                            </address>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                            <p>
                                <em>Date: <?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></em>
                            </p>
                            <p>
                                <em class="text-yellow">Sales Invoice #: <?php echo $order->order_code; ?></em>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            <h2>Sales Invoice</h2>
                        </div>
                        </span>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th></th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $order_items_sql = "SELECT * FROM purchase_detail 
                    LEFT JOIN rpos_products ON rpos_products.prod_id = purchase_detail.prod_id 
                    WHERE purchase_detail.order_id = ?";
                                $order_items_stmt = $mysqli->prepare($order_items_sql);
                                $order_items_stmt->bind_param('s', $order->order_id);
                                $order_items_stmt->execute();
                                $order_items_res = $order_items_stmt->get_result();
                                $grand_total = 0;

                                while ($item = $order_items_res->fetch_object()) {
                                    $subtotal = $item->prod_price * $item->prod_qty;
                                    $grand_total += $subtotal;
                                    ?>
                                    <tr>
                                        <td class="col-md-6"><?php echo $item->prod_name; ?></td>
                                        <td class="col-md-1 text-center"><?php echo $item->prod_qty; ?></td>
                                        <td class="col-md-3 text-center">₱ <?php echo number_format($item->prod_price, 2); ?>
                                        </td>
                                        <td class="col-md-3 text-center">₱ <?php echo number_format($subtotal, 2); ?></td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td>   </td>
                                    <td>   </td>
                                    <td class="text-right">
                                        <p>
                                            <strong>Amount Paid: </strong>
                                        </p>
                                        <p>
                                            <strong>Payment method: </strong>
                                        </p>
                                        <p>
                                            <strong>Change : </strong>
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <p>
                                            <strong>₱ <?php echo $order->paid_amount; ?></strong>
                                        </p>
                                        <p>
                                            <strong> <?php echo $order->pay_method; ?></strong>
                                        </p>
                                        <p>
                                            <strong>₱ <?php echo $order->paid_amount - $order->prod_price; ?></strong>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>   </td>
                                    <td>   </td>
                                    <td class="text-right">
                                        <h4><strong>Total: </strong></h4>-
                                    </td>
                                    <td class="text-center text-danger">
                                        <h4><strong>₱ <?php echo $order->prod_price; ?></strong></h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                    <button id="print" onclick="printContent('Receipt');"
                        class="btn btn-success btn-lg text-justify btn-block">
                        Print <span class="fas fa-print"></span>
                    </button>
                </div>
            </div>
        </div>
    </body>

    </html>
    <script>
        function printContent(el) {
            var restorepage = $('body').html();
            var printcontent = $('#' + el).clone();
            $('body').empty().html(printcontent);
            window.print();
            $('body').html(restorepage);
        }
    </script>
<?php } ?>