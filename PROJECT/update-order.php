<?php
if (isset($_POST['payload'])) {
    $purchase_orders = $_POST['payload'];
    $conn = new mysqli("localhost", "root", "", "inventory"); // Use the object-oriented style
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {
        foreach ($purchase_orders as $po) {
            $received = (int) $po['qtyreceived'];
            $status = $po['status'];
            $row_id = $po['id'];
            $qty_ordered = (int) $po['qtyOrdered'];
            $qty_remaining = $qty_ordered - $received;
            $productId = $po['productId'];

            $sql = "UPDATE order_product 
                    SET quantity_received=?, status=?, quantity_remaining=?, received_at=NOW()
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issi", $received, $status, $qty_remaining, $row_id);
            $stmt->execute();

        
        }

        $response = [
            'success' => true,
            'message' => "Purchase order successfully updated!"
        ];
    } catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => "Error processing your request: " . $e->getMessage()
        ];
    }

    echo json_encode($response);
} else {
    // Handle the case when 'payload' index is not present in $_POST
    $response = [
        'success' => false,
        'message' => "Invalid request. 'payload' data not found."
    ];
    echo json_encode($response);
}
header("Location:view-order.php");
?>
<!-- update the code were needed , so that when the value 
of the quantity_received in the order_product table is
 updated after filling the form that appears after pressing any update button
  , the value of the stocks in the products table is updated too to have the 
  same value as the quantity_received -->
