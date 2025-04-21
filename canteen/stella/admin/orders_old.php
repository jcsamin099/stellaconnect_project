<?php
session_start();
include('config/config.php');
include('config/code-generator.php');
include('config/checklogin.php');
check_login();

include('config/config.php');
if(isset($_POST['productid'])){

   
  $customer=$_POST['customer'];
 

      $total=0;
      $order_id = $_POST['order_id'];
      $order_code  = $_POST['order_code'];
      $customer_id = $_POST['customer_id'];
      $customer_name = $_POST['customer_name'];
      $prod_id  = 'e769e274a3';
      $prod_name = $_POST['pick_up'];
      $prod_price = '0';
      $prod_qty = '0';


      $postQuery = "INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price) VALUES(?,?,?,?,?,?,?,?)";
      $postStmt = $mysqli->prepare($postQuery);
      //bind paramaters
      $rc = $postStmt->bind_param('ssssssss', $prod_qty, $order_id, $order_code, $customer_id, $customer_name, $prod_id, $prod_name, $prod_price);
      $postStmt->execute();

  foreach($_POST['productid'] as $product):
  $proinfo=explode("||",$product);
  $productid=$proinfo[0];
  $iterate=$proinfo[1];
  $sql="select * from rpos_products where prod_id='$productid'";
  $query=$mysqli->query($sql);
  $row=$query->fetch_array();
  
  if (isset($_POST['quantity_'.$iterate])){
    $subt=$row['prod_price']*$_POST['quantity_'.$iterate];
    $total+=$subt;
    $sql="insert into purchase_detail (order_id, prod_id, prod_qty) values ('$order_id', '$productid', '".$_POST['quantity_'.$iterate]."')";
    $mysqli->query($sql);
  }
  endforeach;

      $sql="update rpos_orders set prod_price='$total' where order_id='$order_id' ";
      $mysqli->query($sql);

     if ($postStmt) {
        $success = "Order Submitted" && header("refresh:1; url=payments.php");
      } else {
        $err = "Please Try Again Or Try Later";
      }	
      
      }
else{

}



require_once('partials/_head.php');
?>
<style>
    h2 {
        font-family: 'Arial', sans-serif;
        color: #343a40;
    }
    .table-responsive {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem;
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


            Select On Any Product To Make An Order 
            </div>
            <div class="table-responsive">
            <form method="POST" action="">
            <div class="row">
			<div class="col-md-3">
      <select class="form-control" name="customer_name" id="custName" onChange="getCustomer(this.value)">
                      <option value="">Select Customer Name</option>
                      <?php
                      //Load All Customers
                      $ret = "SELECT * FROM  rpos_customers ";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($cust = $res->fetch_object()) {
                      ?>
                        <option><?php echo $cust->customer_name; ?></option>
                      <?php } ?>
                    </select>
			</div>
      <div class="col-sm-2">
      <input type="text" name="customer_id" readonly id="customerID" class="form-control">
      <input type="hidden" name="order_id" value="<?php echo $orderid; ?>" class="form-control">
                        </div>
                      <div class="col-sm-2">
                    <input type="text" name="order_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                  </div>
                <div class="col-sm-2">
              <input type="time" name="pick_up" value="" class="form-control" value="">
            </div>
			    <div class="col-md-2" style="margin-left:-20px;">
				<button type="submit" class="btn btn-primary" name="sub"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
			</div>
		</div>
    <br>
            <table class="table align-items-center table-flush table-hover" id="employeeTable" >
              <thead>
                <tr>
                    <th scope="col"><b>Action</b></th>
                    <th scope="col"><b>Image</b></th>
                    <th scope="col"><b>Product Code</b></th>
                    <th scope="col"><b>Name</b></th>
                    <th scope="col"><b>Price</b></th>
                    <th scope="col"><b>Quatity</b></th>  
                </tr>
              </thead>
              </table>
    
  </form>
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
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <!-- Responsive DataTables JS -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#employeeTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "fetch_prod.php",
                "columns": [
                    { "data": "prod_trex" },
                    { "data": "prod_img" },
                    { "data": "prod_code" },
                    { "data": "prod_name" },
                    { "data": "prod_price" },
                    { "data": "qty" },
                    
                ]
            });
        });
    </script>
</body>

</html>