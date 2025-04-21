<?php
include('config/config.php');

$start = $_GET['start'];
$length = $_GET['length'];
$search = $_GET['search']['value'];

// Search and filter
$where = '';
if (!empty($search)) {
    $where = "WHERE staff_name LIKE '%$search%' OR staff_email LIKE '%$search%' OR staff_number LIKE '%$search%'";
}

// Fetch total records
$totalRecordsQuery = $mysqli->query("SELECT COUNT(*) as total FROM rpos_staff ");
$totalRecords = $totalRecordsQuery->fetch_assoc()['total'];

// Fetch filtered records
$totalFilteredQuery = $mysqli->query("SELECT COUNT(*) as total FROM rpos_staff $where");
$totalFiltered = $totalFilteredQuery->fetch_assoc()['total'];

// Fetch data
$query = "SELECT * FROM rpos_staff $where LIMIT $start, $length";
$result = $mysqli->query($query);

// Prepare data for JSON
$data = [];
while ($row = $result->fetch_assoc()) {
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