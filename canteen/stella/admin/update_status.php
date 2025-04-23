<?php
session_start();
include('config/config.php');

// Check if the request is coming from a valid source
if (isset($_POST['prod_id']) && isset($_POST['status'])) {
    $prod_id = $_POST['prod_id'];
    $status = $_POST['status']; // '1' for Not Available, '0' for Available

    // Validate the status value
    if ($status !== '0' && $status !== '1') {
        echo json_encode(['success' => false, 'message' => 'Invalid status value.']);
        exit;
    }

    // Prepare the update query
    $query = "UPDATE rpos_products SET status = ? WHERE prod_id = ?";
    $stmt = $mysqli->prepare($query);

    // Check if there are any errors in preparing the statement
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the statement.']);
        exit;
    }

    $stmt->bind_param('ss', $status, $prod_id);

    // Execute the query and return the response
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating status: ' . $stmt->error]);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
