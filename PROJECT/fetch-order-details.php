<?php
// fetch-order-details.php

// Assuming you have a database connection
$conn = mysqli_connect("localhost", "root", "", "inventory");

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data based on batchNumber
$batchNumber = mysqli_real_escape_string($conn, $_POST['batchNumber']);
$query = "SELECT received_at, quantity_received FROM order_product WHERE batch = '$batchNumber'";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch the result as an associative array
$orderDetails = mysqli_fetch_assoc($result);

// Use DateTime object
$dateObj = new DateTime($orderDetails['received_at']);
$formattedDate = $dateObj->format('d/m/Y');


// Close the database connection
mysqli_close($conn);

// Prepare the JSON response
$response = [
    'success' => true,
    'receivedDate' => $formattedDate,
    'quantity' => $orderDetails['quantity_received']
];

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
