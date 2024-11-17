<?php
session_start();

if (
    isset($_POST['supplier_name']) &&
    isset($_POST['supplier_location']) &&
    isset($_POST['email'])
) {
    // Retrieve user ID from the session
    $user_id = $_SESSION['id'];
    $_SESSION['supplier_name'] = $_POST['supplier_name'];
    $_SESSION['supplier_location'] = $_POST['supplier_location'];
    $_SESSION['email'] = $_POST['email'];
    $supplier_name = $_POST['supplier_name'];
    $supplier_location = $_POST['supplier_location'];
    $email = $_POST['email'];

    // Validate if all text fields are filled
    if (empty($supplier_name) || empty($supplier_location) || empty($email)) {
        $response = [
            'success' => false,
            'message' => 'All textfields should be filled for the addition of this Supplier'
        ];
    } else {
        $conn = mysqli_connect("localhost", "root", "");
        mysqli_select_db($conn, "inventory");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $command4 = "INSERT INTO suppliers (supplier_name, supplier_location, email, created_by, created_at, updated_at)
                     VALUES ('$supplier_name', '$supplier_location', '$email', '$user_id', NOW(), NOW())";
                     
        $q4 = mysqli_query($conn, $command4);

        if ($q4) {
            $response = [
                'success' => true,
                'message' => 'Successfully added to the system'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Error: ' . mysqli_error($conn)
            ];
        }
    }

    $_SESSION['response'] = $response;
    header('location: suppliers-add.php');
}
?>
