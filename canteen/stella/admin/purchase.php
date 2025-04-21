<?php
	include('config/config.php');
	if(isset($_POST['productid'])){

 		
		$customer=$_POST['customer'];
   
	
		$total=0;
        $order_id = $_POST['order_id'];
        $order_code  = $_POST['order_code'];
        $customer_id = $_POST['customer_id'];
        $customer_name = $_POST['customer_name'];
        $prod_id  = 'e769e274a3';
        $prod_name = 'N/A';
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
		header('location:payments.php');		
	}
	else{
		?>
		<script>
			window.alert('Please select a product');
			window.location.href='order.php';
		</script>
		<?php
	}
?>