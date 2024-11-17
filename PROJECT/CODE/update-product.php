<?php
session_start();

$conn = new mysqli("localhost", "root", "", "inventory"); // Use the object-oriented style
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['product_id'];
    $productName = $_POST['editproduct_name'];
    $desc = $_POST['editdescription'];

    // Handle file upload
    $targetDir = "IMAGES/";  // Specify the target directory
    $img = basename($_FILES["img"]["name"]);
    $targetFilePath = $targetDir . $img;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)) {
        try {
            $conn->autocommit(FALSE); // Start transaction set autocomit=0

            // Update the product details in the products table
            $update = "UPDATE products SET product_name=?, description=?, img=?, updated_at=NOW() WHERE id=?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("sssi", $productName, $desc, $img, $productId);
            $stmt->execute();
            $stmt->close();

            // Update or insert supplier association
            if (isset($_POST['suppliers'])){
                
                $supplierId =  $_POST['suppliers']; 
               
                // Delete existing supplier associations to be replaced with the new value of supplier
                $deletePrevious = "DELETE FROM productsuppliers WHERE product = ?";
                $stmtDelete = $conn->prepare($deletePrevious);
                $stmtDelete->bind_param("i", $productId); // Assuming product ID is an integer
                $stmtDelete->execute();
                $stmtDelete->close();

                // Insert new supplier association
                $insertSupplier = "INSERT INTO productsuppliers (product, supplier, updated_at, created_at) VALUES (?, ?, NOW(), NOW())";
                $stmtInsert = $conn->prepare($insertSupplier);
                $stmtInsert->bind_param("ii", $productId, $supplierId); // Assuming both IDs are integers
                $stmtInsert->execute();
                $stmtInsert->close();
            }

            $conn->commit(); // Commit transaction
            $response = array('success' => true, 'message' => 'Product updated successfully.');
        } catch (Exception $e) {
            $conn->rollback(); // Rollback in case of an error
            $response = array('success' => false, 'message' => 'Error updating product , you have to choose a supplier for this product.');
        } finally {
            $conn->autocommit(TRUE); // Reset autocommit
        }
        
    } else {
        $response = array('success' => false, 'message' => 'Failed to upload image.');
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
