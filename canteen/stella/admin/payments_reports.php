<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
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
                            <h1 class="text-2xl font-bold">Payment Reports</h1>
                        </div>

                        <!-- Filter Form -->
                        <form method="GET" class="p-3">
                            <div class="row mb-3">
                                <!-- Payment Method Input and Search Button -->
                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="payment_method" class="mr-2 font-weight-bold mb-0">Payment
                                        Method:</label>
                                    <input type="text" name="payment_method" id="payment_method"
                                        class="form-control mr-2" placeholder="Search Payment Method"
                                        value="<?php echo $_GET['payment_method'] ?? ''; ?>">
                                    <button type="submit" class="btn btn-outline-primary">Search</button>
                                </div>


                                <!-- Start Date Input -->
                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="start_date" class="mr-2 font-weight-bold mb-0">From:</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="<?php echo $_GET['start_date'] ?? ''; ?>">
                                </div>

                                <!-- End Date Input -->
                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="end_date" class="mr-2 font-weight-bold mb-0">To:</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="<?php echo $_GET['end_date'] ?? ''; ?>">
                                </div>
                            </div>

                            <!-- Buttons Section -->
                            <div class="d-flex flex-wrap justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary mr-2 mb-2" title="press if desired date is set">Filter</button>
                                <button type="button" class="btn btn-info mr-2 mb-2"
                                    onclick="filterToday()" title="press if want to see all data today">Today</button>
                                <button type="button" class="btn btn-danger mr-2 mb-2"
                                    onclick="clearFilter()" title="press if want to restore all data">Restore</button>
                                <a href="export_payments.php?start_date=<?php echo $_GET['start_date'] ?? ''; ?>&end_date=<?php echo $_GET['end_date'] ?? ''; ?>"
                                    class="btn btn-success mb-2">Export to Excel</a>
                            </div>
                        </form>


                        <!-- Filter Script -->
                        <script>
                            function filterToday() {
                                const today = new Date().toISOString().split('T')[0];
                                document.getElementById('start_date').value = today;
                                document.getElementById('end_date').value = today;
                                document.forms[0].submit();
                            }

                            function clearFilter() {
                                document.getElementById('payment_method').value = '';
                                document.getElementById('start_date').value = '';
                                document.getElementById('end_date').value = '';
                                document.forms[0].submit();
                            }
                        </script>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Payment Code</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Reference Number</th>
                                        <th scope="col">Order Code</th>
                                        <th scope="col">Amount Paid</th>
                                        <th scope="col">Date Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $start_date = $_GET['start_date'] ?? '';
                                    $end_date = $_GET['end_date'] ?? '';
                                    $payment_method = $_GET['payment_method'] ?? '';

                                    $query = "SELECT * FROM rpos_payments WHERE 1=1";
                                    $params = [];
                                    $types = "";

                                    if (!empty($start_date) && !empty($end_date)) {
                                        $query .= " AND DATE(created_at) BETWEEN ? AND ?";
                                        $params[] = $start_date;
                                        $params[] = $end_date;
                                        $types .= "ss";
                                    }

                                    if (!empty($payment_method)) {
                                        $query .= " AND pay_method LIKE ?";
                                        $params[] = '%' . $payment_method . '%';
                                        $types .= "s";
                                    }

                                    $query .= " ORDER BY created_at DESC";
                                    $stmt = $mysqli->prepare($query);

                                    if ($params) {
                                        $stmt->bind_param($types, ...$params);
                                    }

                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $total_income = 0;

                                    while ($payment = $res->fetch_object()) {
                                        $total_income += $payment->pay_amt;
                                        ?>
                                        <tr>
                                            <td><?php echo $payment->pay_code; ?></td>
                                            <td><?php echo $payment->pay_method; ?></td>
                                            <td><?php echo $payment->pay_ref; ?></td>
                                            <td><?php echo $payment->order_code; ?></td>
                                            <td><?php echo $payment->pay_amt; ?></td>
                                            <td><?php echo date('d/M/Y g:i', strtotime($payment->created_at)); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><strong>Gross Income:</strong></td>
                                        <td><strong><?php echo number_format($total_income, 2); ?></strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
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
</body>

</html>