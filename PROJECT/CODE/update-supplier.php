<?php
session_start();

$conn = new mysqli("localhost", "root", "", "inventory"); // Use the object-oriented style

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $supplierId = $_POST['supplier_id'];
    $supplierName = $_POST['supplier_name'];
    $supplierLocation = $_POST['supplier_location'];
    $email = $_POST['email'];

    // Update the SQL query with the correct column names
    $update = "UPDATE suppliers SET supplier_name=?, supplier_location=?, email=?, updated_at=NOW() WHERE id=?";

    // Use prepared statement
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssi", $supplierName, $supplierLocation, $email, $supplierId); // Pass $supplierId by reference
    $stmt->execute();
    $stmt->close();

    $response1 = array('success' => true, 'message' => 'Supplier updated successfully.');
    $_SESSION['response1'] = $response1;

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response1);
    exit();
}
?>
