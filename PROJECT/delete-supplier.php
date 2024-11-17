<?php
session_start();

if (isset($_POST['supplier_id'])) {
    $supplierIdToDelete = $_POST['supplier_id'];
    $conn = mysqli_connect("localhost", "root", "", "inventory");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Start a transaction to ensure atomicity
    mysqli_autocommit($conn, false);
    $success = true;

    try {
        // Step 1: Delete products associated with the supplier from productsuppliers table
        $deleteProductsCommand = "DELETE FROM productsuppliers WHERE supplier = '$supplierIdToDelete'";
        $deleteProductsQuery = mysqli_query($conn, $deleteProductsCommand);

        if (!$deleteProductsQuery) {
            throw new Exception('Error deleting products associated with the supplier: ' . mysqli_error($conn));
        }

        // Step 2: Delete orders associated with the products from order_product table
        $deleteOrdersCommand = "DELETE FROM order_product WHERE product IN (SELECT product FROM productsuppliers WHERE supplier = '$supplierIdToDelete')";
        $deleteOrdersQuery = mysqli_query($conn, $deleteOrdersCommand);

        if (!$deleteOrdersQuery) {
            throw new Exception('Error deleting orders associated with the products: ' . mysqli_error($conn));
        }

        // Step 3: Delete the supplier from the suppliers table
        $deleteSupplierCommand = "DELETE FROM suppliers WHERE id = '$supplierIdToDelete'";
        $deleteSupplierQuery = mysqli_query($conn, $deleteSupplierCommand);

        if (!$deleteSupplierQuery) {
            throw new Exception('Error deleting supplier: ' . mysqli_error($conn));
        }

        // If all steps are successful, commit the transaction
        mysqli_commit($conn);
    } catch (Exception $e) {
        // If any step fails, rollback the transaction and set success to false
        mysqli_rollback($conn);
        $success = false;
        $_SESSION['response5'] = [
            'success' => false,
            'message' => 'Error processing your request: ' . $e->getMessage()
        ];
    }

    // Close the database connection
    mysqli_close($conn);

    // Return the response
    if ($success) {
        $_SESSION['response5'] = [
            'success' => true,
            'message' => 'Supplier and associated products/orders successfully deleted.'
        ];
    }

    echo json_encode($_SESSION['response5']);
} else {
    $_SESSION['response5'] = [
        'success' => false,
        'message' => 'Supplier ID not specified.'
    ];

    echo json_encode($_SESSION['response5']);
}
?>
