<?php 

$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$statuses = ['pending', 'complete', 'incomplete'];
$results = [];

//Loop through statuses and query
foreach($statuses as $status){
    $stmt ="SELECT COUNT(*) as status_count FROM order_product WHERE status ='" . $status . "'";
    $res=mysqli_query($conn,$stmt);
    $row = mysqli_fetch_array($res);

    $count = $row['status_count'];
    
    $results[] = [
        'name' => strtoupper($status),
         'y'=>(int)$count
    ];
}

?>