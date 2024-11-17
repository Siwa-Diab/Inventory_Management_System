<?php
session_start();

$conn = new mysqli("localhost", "root", "", "inventory"); // Use the object-oriented style
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $userId = $_POST['user_id'];   // we write them the same way they are assigned in the ajax request
    $firstName = $_POST['first_name'];              // these are the values found in the editting form
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];

    // Update the SQL query with the correct column names
    // This is a prepared statement , the ? is the parameter and they are respectively placed in the bind_param
    $update = "UPDATE users SET first_name=?, last_name=?, email=?, updated_at=NOW() WHERE id=?";

    // Use prepared statement
    //sssi means that i have three strings in the parameter followed by an integer
    $stmt = $conn->prepare($update); // im indicating that this query is a prepared statement
    $stmt->bind_param("sssi", $firstName, $lastName, $email, $userId); // Pass $userId by reference
    $stmt->execute();
    $stmt->close();

    $response1 = array('success' => true, 'message' => 'User updated successfully.');
    $_SESSION['response1'] = $response1;

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response1);
    exit();
}
?>
