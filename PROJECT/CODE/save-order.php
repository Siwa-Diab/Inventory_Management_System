<?php
session_start();

$post_data = $_POST;
$products = $post_data['products'];
$qty = $post_data['quantity'];
$batch = time();

if (isset($_POST['products']) && isset($_POST["quantity"])) {
    // Retrieve user ID from the session
    $user_id = $_SESSION['id'];
    $sn = $_SESSION['supplier'];

    $conn = mysqli_connect("localhost", "root", "");
    mysqli_select_db($conn, "inventory");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $b = "SELECT id FROM suppliers WHERE supplier_name='$sn'";
    $r = mysqli_query($conn, $b);
    $rr = mysqli_fetch_array($r);
    $sid = $rr['id'];

    // Validate if all text fields are filled
    if (empty($products) || empty($qty)) {
        $response = [
            'success' => false,
            'message' => 'All textfields should be filled for the addition of this Supplier'
        ];
    } else {
        $response = [
            'success' => true,
            'message' => 'Order successfully created!'
        ];

        foreach ($products as $pid) {
            $command4 = "INSERT INTO order_product (supplier, product, quantity_ordered,quantity_received, status, batch, created_by, created_at, updated_at, received_at)
                         VALUES ('$sid', '$pid', '$qty', '0', 'incomplete', '$batch', '$user_id', NOW(), NOW(), NOW())";

            $q4 = mysqli_query($conn, $command4);

            if (!$q4) {
                $response = [
                    'success' => false,
                    'message' => 'Error: ' . mysqli_error($conn)
                ];
                break; // Exit the loop if an error occurs
            }
        }

        $_SESSION['response'] = $response;
        header('Location: product-order.php');
        exit(); // Exit the script to prevent further execution
    }
}
?>
