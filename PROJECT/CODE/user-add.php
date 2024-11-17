<?php
session_start();

if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password'])) {
    // Check if any of the fields are empty
    
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['password'])) {
        // hayde reje3et sta3malta bi2alb l session bihayde l saf7a
        $response = [
            'success' => false,
            'message' => 'All fields are required. Please fill out all the fields.'
        ];

        $_SESSION['response'] = $response;
        header('location: users-add.php');
        exit();
    }
    
    $first_name = $_POST['first_name']; // Use the new user's first name
    $last_name = $_POST['last_name']; // Use the new user's last name
    $email = $_POST['email'];;
    $password = $_POST['password'];
    $encrypted = password_hash($password, PASSWORD_DEFAULT); // password_hash is a function used to hash the password and make it more complicated 

    $conn = mysqli_connect("localhost", "root", "");
    mysqli_select_db($conn, "inventory");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $command = "INSERT INTO users (id,first_name, last_name, email, password, created_at, updated_at, status)
            VALUES ('', '$first_name', '$last_name', '$email', '$encrypted', NOW(), NOW(), '0')";

    $q1 = mysqli_query($conn, $command);

    if ($q1) {
        $response = [
            'success' => true,
            'message' => $first_name . ' ' . $last_name . ' successfully added to the system'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error: ' . mysqli_error($conn)
        ];
    }

    $_SESSION['response'] = $response;
}

header('location: users-add.php');
?>
