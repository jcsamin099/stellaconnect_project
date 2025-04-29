<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check database connection
if (!$mysqli) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Get filters
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// Query
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

// Check results
if ($res->num_rows == 0) {
    die('No payments found.');
}

// Fetch all payments into array
$payments = [];
while ($payment = $res->fetch_object()) {
    $payments[] = $payment;
}

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set Headers
$sheet->setCellValue('A1', 'Payment Code')
      ->setCellValue('B1', 'Payment Method')
      ->setCellValue('C1', 'Reference Number')
      ->setCellValue('D1', 'Order Code')
      ->setCellValue('E1', 'Amount Paid')
      ->setCellValue('F1', 'Date Paid');

// Fill Data
$row = 2;
foreach ($payments as $payment) {
    $sheet->setCellValue('A' . $row, $payment->pay_code);
    $sheet->setCellValue('B' . $row, $payment->pay_method);
    $sheet->setCellValue('C' . $row, $payment->pay_ref);
    $sheet->setCellValue('D' . $row, $payment->order_code);
    $sheet->setCellValue('E' . $row, $payment->pay_amt);
    $sheet->setCellValue('F' . $row, date('d/M/Y g:i', strtotime($payment->created_at)));
    $row++;
}

// Auto-size columns
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Prepare for Download
$filename = 'payment_reports_' . date('Ymd_His') . '.xlsx';

// Clear output buffer if any previous output
if (ob_get_length()) {
    ob_end_clean();
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

// Save and output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
