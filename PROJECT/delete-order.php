<?php
session_start();

if (isset($_POST['order_id'])) {
    $orderIdToDelete = $_POST['order_id'];

    $conn = mysqli_connect("localhost", "root", "", "inventory");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Perform the deletion here
    $deleteCommand = "DELETE FROM order_product WHERE id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteCommand);
    
    if ($deleteStmt) {
        mysqli_stmt_bind_param($deleteStmt, "i", $orderIdToDelete);
        $success = mysqli_stmt_execute($deleteStmt);
    
        if ($success) {
            $_SESSION['response1'] = [
                'success' => true,
                'message' => 'Order successfully deleted.'
            ];
        } else {
            $_SESSION['response1'] = [
                'success' => false,
                'message' => 'Error deleting order: ' . mysqli_error($conn)
            ];
        }
    
        mysqli_stmt_close($deleteStmt);
    } else {
        $_SESSION['response1'] = [
            'success' => false,
            'message' => 'Error preparing delete statement.'
        ];
    }
    echo json_encode($_SESSION['response1']);
}    
?>
