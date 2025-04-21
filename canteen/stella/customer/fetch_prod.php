<?php
include('config/config.php');

$start = $_GET['start'];
$length = $_GET['length'];
$search = $_GET['search']['value'];

// Search and filter
$where = 'WHERE status = 0';
if (!empty($search)) {
    $where = "WHERE prod_code LIKE '%$search%' OR prod_name LIKE '%$search%' and status='0' ";
}

// Fetch total records
$totalRecordsQuery = $mysqli->query("SELECT COUNT(*) as total FROM rpos_products ");
$totalRecords = $totalRecordsQuery->fetch_assoc()['total'];

// Fetch filtered records
$totalFilteredQuery = $mysqli->query("SELECT COUNT(*) as total FROM rpos_products $where");
$totalFiltered = $totalFilteredQuery->fetch_assoc()['total'];

// Fetch data
$query = "SELECT * FROM rpos_products $where LIMIT $start, $length";
$result = $mysqli->query($query);

// Prepare data for JSON
$data = [];
$iterate = 0 ;
while ($row = $result->fetch_assoc()) {
    if($row['prod_img']){
        $row['prod_img'] = '<img src="../admin/assets/img/products/' . $row['prod_img'] . '" alt="Product Image" class="img-thumbnail" style="width: 60px; height: 60px;">';
    }else{
        $row['prod_img'] = "<img src='../admin/assets/img/products/default.jpg' height='60' width='60 class='img-thumbnail'>";
    }
    $row['prod_trex'] = '<input type="checkbox" value="'.$row['prod_id'].'||'.$iterate.'" name="productid[]" style="">';
    $row['qty']  = '<input type="text" class="form-control" name="quantity_'.$iterate.'">';
    $iterate++;
    $data[] = $row;
}

// Return JSON response
$response = [
    "draw" => intval($_GET['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $data
];

echo json_encode($response);


?>