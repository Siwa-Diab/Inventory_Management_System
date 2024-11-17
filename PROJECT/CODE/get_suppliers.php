<?php
session_start();

// Assume you have a database connection here
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = mysqli_real_escape_string($conn, $_GET['product_id']); // Prevent SQL injection

$q = "SELECT supplier_name FROM suppliers, productsuppliers WHERE productsuppliers.product = '$product_id' AND productsuppliers.supplier = suppliers.id";
$r = mysqli_query($conn, $q);

// Fetch the supplier name directly as a string
$supplier = '';
if ($row = mysqli_fetch_assoc($r)) {
    $supplier = $row['supplier_name'];
    $_SESSION['supplier'] = $supplier;
}

echo json_encode($supplier);

mysqli_close($conn);
?>
