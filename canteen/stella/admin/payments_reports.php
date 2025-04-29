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
                            <h1 class="text-2xl font-bold">Payment Reports</h1>
                        </div>
                        <form method="GET" class="form-inline p-3">
                            <label for="start_date" class="mr-2">From:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control mr-3"
                                value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">

                            <label for="end_date" class="mr-2">To:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control mr-3"
                                value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">

                            <button type="submit" class="btn btn-primary">Filter</button>

                            <a href="export_payments.php?start_date=<?php echo $_GET['start_date'] ?? ''; ?>&end_date=<?php echo $_GET['end_date'] ?? ''; ?>"
                                class="btn btn-success ml-2">Export to Excel</a>
                        </form>
                        <br>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr class="">
                                        <th scope="col">Payment Code</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Referece number</th>
                                        <th scope="col">Order Code</th>
                                        <th scope="col">Amount Paid</th>
                                        <th scope="col">Date Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $start_date = $_GET['start_date'] ?? '';
                                    $end_date = $_GET['end_date'] ?? '';

                                    if ($start_date && $end_date) {
                                        $ret = "SELECT * FROM rpos_payments WHERE DATE(created_at) BETWEEN ? AND ? ORDER BY `created_at` DESC";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->bind_param('ss', $start_date, $end_date);
                                    } else {
                                        $ret = "SELECT * FROM rpos_payments ORDER BY `created_at` DESC";
                                        $stmt = $mysqli->prepare($ret);
                                    }
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $total_income = 0;
                                    while ($payment = $res->fetch_object()) {
                                        $total_income += $payment->pay_amt;
                                        ?>
                                        <tr>
                                            <th class="" scope="row">
                                                <?php echo $payment->pay_code; ?>
                                            </th>
                                            <th scope="row">
                                                <?php echo $payment->pay_method; ?>
                                            </th>
                                            <td class="">
                                                <?php echo $payment->pay_ref; ?>
                                            </td>
                                            <td class="">
                                                <?php echo $payment->order_code; ?>
                                            </td>
                                            <td>
                                                <?php echo $payment->pay_amt; ?>
                                            </td>
                                            <td class="">
                                                <?php echo date('d/M/Y g:i', strtotime($payment->created_at)) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th><strong>Gross Income:</strong></th>
                                        <th><strong><?php echo number_format($total_income, 2); ?></strong></th>
                                    </tr>
                                </tfoot>
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