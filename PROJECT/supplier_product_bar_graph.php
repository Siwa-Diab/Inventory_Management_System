<?php 
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt ="SELECT id,supplier_name FROM suppliers";
$res=mysqli_query($conn,$stmt);
$categories = [];
$bar_chart_data = [];
$colors = ['#FF0000','0000FF','#ADD8E6','#800080','#00FF00','#FF00FF','#FFA500','#800000'];

//Query supplier product count
$counter = 0; // this counter is used for giving the maximum number of products each supplier has

while ($row = mysqli_fetch_array($res)) {

    $id = $row['id'];
    $categories[]= $row['supplier_name']; // we stored all the suppliers names in the categories array
    //Query count.
    $stmt ="SELECT COUNT(*) as p_count FROM productsuppliers WHERE productsuppliers.supplier='" . $id . "'";

    $res_count=mysqli_query($conn,$stmt);
    $row_count = mysqli_fetch_array($res_count);
    $count = $row_count['p_count'];

    if(!isset($colors[$counter])) {
        $counter=0;
    }

    $bar_chart_data[] =[
        'y' => (int) $count,
        'color' => $colors[$counter]
    ];

    $counter++; // to increment the number of different colors for every extra bar
}
?>
