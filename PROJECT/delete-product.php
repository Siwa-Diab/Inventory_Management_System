<?php
session_start();

if (isset($_POST['product_id'])) { // l id lal product lali badde 2a3melo delete

    $productIdToDelete = $_POST['product_id'];

    $conn = mysqli_connect("localhost", "root", "", "inventory");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Perform the deletion here
    try {
        $deleteCommand = "DELETE FROM products WHERE id = '$productIdToDelete'";

        $deleteQuery   = mysqli_query($conn, $deleteCommand);

        if ($deleteQuery) {
            $_SESSION['response2'] = [
                'success' => true,
                'message' => 'User successfully deleted.'
            ];
        } else {
            $_SESSION['response2'] = [
                'success' => false,
                'message' => 'Error deleting user: ' . mysqli_error($conn)
            ];
        }
    } catch (Exception $e) {
        $_SESSION['response2'] = [
            'success' => false,
            'message' => 'Error processing your request: ' . $e->getMessage()
        ];
    }

    // Close the database connection
    mysqli_close($conn);

    echo json_encode($_SESSION['response2']);
} else {
    // Handle the case where user_id is not set in the POST data
    $_SESSION['response2'] = [
        'success' => false,
        'message' => 'User ID not specified.'
    ];

    echo json_encode($_SESSION['response2']);
}
?>
