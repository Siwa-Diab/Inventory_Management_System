<?php
$type = $_GET['report'];
$file_name = '.xls';

$mapping_filenames = [
    'supplier' => 'supplier Report',
    'product' => 'product Report',
    'purchase_orders' => 'Purchase Order Report',
];

$file_name = $mapping_filenames[$type] . '.xls'; // Fix the file name concatenation
header('Content-Disposition: attachment; filename="' . $file_name . '"'); // Fix the header
header('Content-Type: application/vnd.ms-excel');
//pull data from database
$conn = mysqli_connect("localhost", "root", "", "inventory");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Product Export
if ($type === 'product') {
    $stmt = "SELECT * FROM products INNER JOIN users ON products.created_by = users.id ORDER BY products.created_at DESC";
    $res = mysqli_query($conn, $stmt);
  
    $is_header = true;
    while ($products = mysqli_fetch_assoc($res)) {
        $products['created_by'] = $products['first_name'] . ' ' . $products['last_name'];
        unset($products['first_name'],$products['last_name'],$products['password'],$products['email'],$products['status']);
        if ($is_header) {
            $row = array_keys($products);
            $is_header = false;
            echo implode("\t", $row) . "\n";
        }
        echo implode("\t", $products) . "\n";
    }
}
//Supplier Export 
if ($type === 'supplier') {
    $stmt = "SELECT suppliers.id as sid,suppliers.created_at as 'created at',users.first_name,users.last_name,
    suppliers.supplier_location,suppliers.email,suppliers.created_by
     FROM suppliers INNER JOIN users ON suppliers.created_by = users.id ORDER BY suppliers.created_at DESC";
    $res = mysqli_query($conn, $stmt);
  
    $is_header = true;
    while ($suppliers = mysqli_fetch_assoc($res)) {
        $suppliers['created_by'] = $suppliers['first_name'] . ' ' . $suppliers['last_name'];
        unset($suppliers['first_name'],$suppliers['last_name']);
        if ($is_header) {
            $row = array_keys($suppliers);
            $is_header = false;
            echo implode("\t", $row) . "\n";
        }
        //detect double-quotes and escape any value that contains them
        array_walk($suppliers,function($str){
        $str = preg_replace("/\t/","\\t",$str);
        $str = preg_replace("/\r?\n/","\\n",$str);
        if(strstr($str,'"')) $str = '"' .str_replace('"','""',$str) . '"';
        });
        echo implode("\t", $suppliers) . "\n";
    }
}
//Purchase Order Export 
if ($type === 'purchase_orders') {
    $stmt = "SELECT order_product.id, order_product.quantity_ordered, order_product.quantity_received,
     order_product.quantity_remaining, order_product.status, order_product.batch, users.first_name, users.last_name, suppliers.supplier_name,
     order_product.created_at as 'order product created at' 
     FROM order_product 
     INNER JOIN users ON order_product.created_by = users.id
     INNER JOIN suppliers ON order_product.supplier = suppliers.id
     ORDER BY order_product.batch DESC";
    $res = mysqli_query($conn, $stmt);

    // Group by batch
    $pos = [];
    while ($order_products = mysqli_fetch_assoc($res)) {
        $order_products['created_by'] = $order_products['first_name'] . ' ' . $order_products['last_name'];
        unset($order_products['first_name'], $order_products['last_name']);
        $pos[$order_products['batch']][] = $order_products;
    }

    // Output headers
    $is_header = true;
    foreach ($pos as $order_product) {
        foreach ($order_product as $row) {
            if ($is_header) {
                $header = array_keys($row);
                echo implode("\t", $header) . "\n";
                $is_header = false;
            }
            array_walk($row, function (&$str) {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            });
            echo implode("\t", $row) . "\n";
        }
        // New Line
        echo "\n";
    }
}
// Close the connection
mysqli_close($conn);
?>
