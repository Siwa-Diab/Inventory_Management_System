<?php
// process-deliveries.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission and process the data
    $dateReceived = $_POST['date_received'];
    $quantity = $_POST['quantity'];

    
    $response = [
        'success' => true,
        'message' => 'Delivery information submitted successfully.',
    ];

    echo json_encode($response);
    exit;
}
?>
