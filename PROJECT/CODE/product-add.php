<?php
session_start();

if (isset($_POST['product_name']) && isset($_POST['description'])) {
    // Retrieve user ID from the session
    $user_id = $_SESSION['id'];

    // Validate form fields
    if (empty($_POST['product_name']) || empty($_POST['description']) || empty($_FILES['img']['name'])) {
        $response = [
            'success' => false,
            'message' => 'Please fill in all the fields and select an image.'
        ];
        $_SESSION['response'] = $response;
        header('location: products-add.php');
        exit();
    }

    // Check if a supplier is selected
    if (empty($_POST['supplier'])) {
        $response = [
            'success' => false,
            'message' => 'Please select a supplier from the list.'
        ];
        $_SESSION['response'] = $response;
        header('location: products-add.php');
        exit();
    }

    $target_dir = "./IMAGES";
    $file_data = $_FILES['img'];
    $file_name = $file_data['name'];
    $check = getimagesize($file_data['tmp_name']);

    if (!$check) {
        $response = [
            'success' => false,
            'message' => 'Invalid image file.'
        ];
        $_SESSION['response'] = $response;
        header('location: products-add.php');
        exit();
    }

    if (!move_uploaded_file($file_data['tmp_name'], $file_name)) {
        $response = [
            'success' => false,
            'message' => 'Error uploading the image.'
        ];
        $_SESSION['response'] = $response;
        header('location: products-add.php');
        exit();
    }

    // Save the file_name to the database
    $value = $file_name;

    $_SESSION['product_name'] = $_POST['product_name'];
    $_SESSION['description'] = $_POST['description'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];

    $conn = mysqli_connect("localhost", "root", "");
    mysqli_select_db($conn, "inventory");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $command2 = "INSERT INTO products (product_name, description, img, created_by, created_at, updated_at)
                 VALUES ('$product_name','$description', '$value', '$user_id', NOW(), NOW())";
    
    $q2 = mysqli_query($conn, $command2);

    if ($q2) {
        // Retrieve the last inserted product ID
        $product_id = mysqli_insert_id($conn);

        // Retrieve selected supplier
        $selected_supplier = $_POST['supplier'];

        // Insert record into productsuppliers table for the selected supplier
        $command3 = "INSERT INTO productsuppliers (supplier, product, updated_at, created_at)
                      VALUES ('$selected_supplier', '$product_id', NOW(), NOW())";
        
        $q3 = mysqli_query($conn, $command3);

        // Handle the error if the query fails
        if (!$q3) {
            $response = [
                'success' => false,
                'message' => 'Error in productsuppliers query: ' . mysqli_error($conn)
            ];
            $_SESSION['response'] = $response;
            header('location: products-add.php');
            exit();
        }

        // If the loop completes successfully
        $response = [
            'success' => true,
            'message' => 'Successfully added to the system'
        ];
        $_SESSION['response'] = $response;
        header('location: products-add.php');
        exit();
    } else {
        $response = [
            'success' => false,
            'message' => 'Error: ' . mysqli_error($conn)
        ];
        $_SESSION['response'] = $response;
        header('location: products-add.php');
        exit();
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request.'
    ];
    $_SESSION['response'] = $response;
    header('location: products-add.php');
    exit();
}
?>
