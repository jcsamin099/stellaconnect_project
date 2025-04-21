<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>
<?php

if(isset($_GET['ID'])){
    $query = $mysqli->query("UPDATE rpos_orders SET order_status = 'Verified' WHERE order_id = '".$_GET['ID']."' ");

    if($query){
        echo '<script>alert("Updating order status Success");window.open("","_self")</script>';
    }
}


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
        <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
                            Orders Records
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-yellow" scope="col">Code</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Total Price</th>
                                        <th scop="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  rpos_orders ORDER BY `created_at` DESC  ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                        $total = ($order->prod_price);

                                    ?>
                                        <tr>
                                            <th class="text-yellow" scope="row"><?php echo $order->order_code; ?></th>
                                            <td><?php echo $order->customer_name; ?></td>
                                           
                                        
                                       
                                            <td><?php echo $total; ?></td>
                                            <td><?php if ($order->order_status == '') {
                                                    echo "<span class='badge badge-danger'>Not Paid</span>";
                                                } elseif ($order->order_status == 'Paid') {
                                                    echo "<span class='badge badge-success'>$order->order_status</span>";
                                                }else{
                                                    echo "<span class='badge badge-info'>$order->order_status</span>";
                                                } ?></td>
                                            <td><?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></td>
                                            <td><!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#details<?php echo $order->order_id; ?>">
  View
</button>                                      <?php if ($order->order_status == 'Paid') { ?>
                                                  <a href="orders_reports.php?ID=<?= $order->order_id ?>"  class="btn btn-info">Paid</a>
                                               <?php } else {  ?>
                                      
                                                <?php } ?>

<!-- Modal -->
<div class="modal fade" id="details<?php echo $order->order_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center><h4 class="modal-title" id="exampleModal">Order Full Details</h4></center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
                    <h5>Customer: <b><?php echo $order->customer_name; ?></b>
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
                                $sql="select * from purchase_detail left join rpos_products on rpos_products.prod_id=purchase_detail.prod_id where order_id='".$order->order_id."'";
                                $dquery=$mysqli->query($sql);
                                while($drow=$dquery->fetch_array()){
                                    ?>
                                    <tr>
                                        <td><?php echo $drow['prod_name']; ?></td>
                                        <td class="text-right">&#8369; <?php echo number_format($drow['prod_price'], 2); ?></td>
                                        <td><?php echo $drow['prod_qty']; ?></td>
                                        <td class="text-right">&#8369;
                                            <?php
                                                $subt = $drow['prod_price']*$drow['prod_qty'];
                                                echo number_format($subt, 2);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    
                                }
                            ?>
                            <tr>
                                <td colspan="3" class="text-right"><b>TOTAL</b></td>
                                <td class="text-right">&#8369; <?php echo number_format($order->prod_price, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div></td>
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