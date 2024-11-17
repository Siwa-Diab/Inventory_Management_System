<?php
session_start();

$_SESSION['table'] = 'users';
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "inventory");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch values from session
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$last_name  = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Advanced Dashboard</title>

    <!--    All of the links added below are for the bootstrap configuartion  -->

    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Add Bootstrap Dialog CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css">
    <!-- Add Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Add Bootstrap Dialog JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.min.js"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-y: auto;
        }

        #dashboardContainer {
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: black;
            color: #f685a1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: fixed; /* Keep the sidebar fixed */
            height: 100%;
            overflow-y: auto;
        }

        .logo {
            font-size: 40px; /* Larger font size for IMS logo */
            font-weight: bold;
            color: #f685a1; /* Match the requested color */
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px; /* Reduced margin */
            position: relative;
        }

        .logo::before,
        .logo::after {
            content: "";
            position: absolute;
            height: 4px;
            width: 30px;
            background: #f685a1; /* Match the requested color */
        }

        .logo::before {
            top: -10px;
        }

        .logo::after {
            bottom: -10px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #f685a1; /* Line under the name */
            padding-bottom: 10px; /* Padding under the name */
        }

        .user-info img {
            width: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        /* Navigation Styles */
        .navigation {
            background: black;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Dashboard Content Styles */
        .dashboard-content {
            flex: 1;
            padding: 20px;
            background-color: #f685a1; /* Background color behind "Welcome to Dashboard!" */
            color: #fff; /* Text color */
            overflow-y: auto;
            margin-left:18.75%;
        }

        /* Dashboard Styles */
        .dashboard {
            margin-top: 30px; /* Increased spacing */
        }

        .dashboard a {
            text-decoration: none;
            color: #fff;
            display: block;
            margin-bottom: 20px; /* Increased spacing */
            background-color: black; /* Initial background color */
            padding:0px 10px;
            transition: background-color 0.3s, font-size 0.3s; /* Transition for background color and font size change on hover */
        }

        .dashboard a:hover {
            background-color: #f685a1; /* Change background color on hover */
            color: #fff; /* Change text color on hover */
            font-size: 18px; /* Larger font size on hover */
        }

        /* Logout Button Styles */
        .logout-btn {
            background: #f00;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: auto; /* Move the logout button to the right */
        }

      
        form::after{   /* after click on the button I want to clear everything in writted in inputs*/
            content: '';
            clear: both;
            display: block;
        }
       
        div.column{
            width: 100%;
            padding: 0px 10px;
        }
       
        div.column-7{
            width:100%;  /*the second part of the page  */
            margin-top: 100px;
        }
        
        h1.section_header{
            font-size: 21px;
            color: #fff;
            border-bottom: 1px solid black;
            padding-bottom: 11px;
            padding: 10px;
            border-left:4px solid black ;
            margin-bottom: 15px;
        }
        /* Adjust the border properties to make it shorter */
        h1.section_header:after {
            content: "";
            display: block;
            border-bottom: 1px solid black; /* New border properties for the line underneath */
            margin-top: 20px; /* Adjust the margin to control the length of the line */
        }
        
        table, th, td{
            border:1px solid #cacaca;
            border-collapse:collapse;
        }
        table{
            width: 100%;
        }
        table th{
            font-size: 12px;
            text-transform: uppercase;
            text-align: center;
            background: #7d7d7d;
            padding:9px;
        }
        table td{
            font-size: 12px;
            text-align: center;
            padding: 7px;
            white-space: wrap;
        }
        /* Adjust the width of individual columns as needed */
        p.userCount{
            text-align: right;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            color: #fff;
        }
        #editFormContainer {
            display: none;
            position: fixed;
            top: 150px;
            left: 25%;
            width: 50%;
            justify-content: center;
            align-items: center;
            border:3px solid black;
            border-radius: 15px solid black;
        }

        #editForm {
              background-color:lightgrey; /* White background for the form */
              padding: 20px;
              border-radius: 5px;
              box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Box shadow for a subtle lift effect */
        }

        #editForm label {
               display: block;
               margin-bottom: 10px;
        }

        #editForm input {
               width: 100%;
               padding: 5px;
               margin-bottom: 15px;
               box-sizing: border-box;
        }

        #editOkBtn {
               background-color: #f685a1; /* Match the color scheme */
               color: #fff;
               padding: 10px 20px;
               border: 2px solid black;
               border-radius: 5px;
               cursor: pointer;
         }

        #editOkBtn:hover {
               background-color: #d84367; /* Darker shade on hover */
        }

        ul.subMenus1{
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.subMenus1 li {
           margin-bottom: 10px;
        }

        ul.subMenus1 li a {
           text-decoration: none;
           color: #fff;
           display: flex;
           align-items: center;
        }

        ul.subMenus1 li a i {
            margin-right: 10px;
            font-size: 14px;
        }

        ul.subMenus1 li a:hover {
            background-color: #333; /* Change background color on hover */
            border-radius: 5px;
        }

        ul.subMenus1 li a i.fa-circle {
            color: #f685a1; /* Match the requested color */
        }
        ul.subMenus2{
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.subMenus2 li {
           margin-bottom: 10px;
        }

        ul.subMenus2 li a {
           text-decoration: none;
           color: #fff;
           display: flex;
           align-items: center;
        }

        ul.subMenus2 li a i {
            margin-right: 10px;
            font-size: 14px;
        }

        ul.subMenus2 li a:hover {
            background-color: #333; /* Change background color on hover */
            border-radius: 5px;
        }

        ul.subMenus2 li a i.fa-circle {
            color: #f685a1; /* Match the requested color */
        }
        ul.subMenus3{
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.subMenus3 li {
           margin-bottom: 10px;
        }

        ul.subMenus3 li a {
           text-decoration: none;
           color: #fff;
           display: flex;
           align-items: center;
        }

        ul.subMenus3 li a i {
            margin-right: 10px;
            font-size: 14px;
        }

        ul.subMenus3 li a:hover {
            background-color: #333; /* Change background color on hover */
            border-radius: 5px;
        }

        ul.subMenus3 li a i.fa-circle {
            color: #f685a1; /* Match the requested color */
        }
        ul.subMenus4{
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.subMenus4 li {
           margin-bottom: 10px;
        }

        ul.subMenus4 li a {
           text-decoration: none;
           color: #fff;
           display: flex;
           align-items: center;
        }

        ul.subMenus4 li a i {
            margin-right: 10px;
            font-size: 14px;
        }

        ul.subMenus4 li a:hover {
            background-color: #333; /* Change background color on hover */
            border-radius: 5px;
        }

        ul.subMenus4 li a i.fa-circle {
            color: #f685a1; /* Match the requested color */
        }

        i.mainMenuIconArrow {
            float: right;
            font-size: 19px;/* !important after a CSS property value, it signifies that this particular style should take precedence over other conflicting styles, regardless of their specificity*/
            margin-left: 7px;
            transition: transform 0.3s; /* Added transition property for smooth animation */
        }

        i.rotateDown {
            transform: rotate(90deg); /* Rotates the icon 90 degrees */
        }
        a.liMainMenu_link.active {
         background-color: #f685a1;
        }
        
        i.rotateDown {
            transform: rotate(-90deg); /* Rotates the icon 90 degrees */
        }
       .poList{
        margin-bottom: 25px;
        padding: 15px;
        border-bottom: solid 1px #d1d1d1;
        border-radius: 5px;
        background: #fbfbfb;
       }
       .poList p{
        font-weight: bold;
        text-transform: uppercase;
        color: #d55f7d;
        font-size: 16px;
       }
       .poList table td, .poList table th{
        border: none;
        border-bottom: 1px dotted #b7b7b7;
        color: #333;
       }
      
       .poList table{
        border: #7d7d7d;
       }
       .poOrderUpdateBtnContainer {
        text-align: right;
        }
       .updatepoBtn{
        margin-top: 20px;
        background-color: #d55f7d;
        color: #fff;
        border: #d55f7d;
        transition: background-color 0.3s, color 0.3s;
       }
       .updatepoBtn:hover{
        background: #d1d1d1;
        color: #d55f7d;
       }
       .po-badge{
        padding: 4px 6px;
        border: 1px solid;
       }
       .po-badge-pending{
        background:#ff7c76;
        border-color: #556455;
       }
       .po-badge-complete{
        background:lawngreen;
        border-color: green;
       }
       .po-badge-incomplete{
         background: #f7e640;
         color: #392b2b;
         border-color: #a3a3a3;
       }
       .alignLeft{
        text-align: left;
       }
       .deliveries{
        background-color: lightseagreen; /* Change this to your desired color */
        color: #fff; /* Text color */
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
       }
       .deliveries:hover{
        color:black;
        border: 1px solid darkgreen;
       }
       .removepoBtn{
        margin-top: 20px;
        background-color: #ff7c76;
        color: #fff;
        border: #d55f7d;
        transition: background-color 0.3s, color 0.3s;
       }
       .removepoBtn:hover{
        background: #fbfbfb;
        color: #ff7c76;
       }
    </style>
    <script>
      function showDeliveryForm(batchNumber) {
    // Fetch data from the server using AJAX 

    // the Bootstrap dialogue that pops out after pressing the deliveries button 

    $.ajax({
        type: 'POST',
        url: 'fetch-order-details.php',
        data: { batchNumber: batchNumber },
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                // Dynamically create the form with default values
                var formHtml = '<form id="deliveryForm" action="process-deliveries.php" method="post">' +
                    '<h1>Delivery Information for Batch #: ' + batchNumber + '</h1>' +
                    '<table>' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Date Received</th>' +
                    '<th>Quantity</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr>' +
                    '<td><input type="text" name="date_received[]" value="' + data.receivedDate + '" required readonly></td>' +
                    '<td><input type="number" name="quantity[]" value="' + data.quantity + '" required readonly></td>' +
                    '</tr>' +
                    '</tbody>' +
                    '</table>' +
                    '</form>';

                // Show the form using BootstrapDialog
                BootstrapDialog.show({
                    title: 'Delivery Form',
                    message: formHtml,
                    closable: true,
                    draggable: true,
                    buttons: [{
                        label: 'Close',
                        action: function (dialogRef) {
                            dialogRef.close();
                        }
                    }]
                });
            } else {
                alert('Failed to fetch order details. Please try again.');
            }
          },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
}
</script>
</head>
<body>
    <div id="dashboardContainer">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">IMS</div>
            <div class="user-info">
                <img src="./IMAGES/profile.png" alt="User Image">
                <span><?php echo"$first_name $last_name" ;  ?></span>
            </div>
            <div class="dashboard">
                <a href="dashboard.php"><i class="fa fa-dashboard"></i> &nbsp;&nbsp;Dashboard</a>
                <a href="report.php"><i class="fa fa-file"></i> &nbsp;&nbsp;Reports</a>
               <a  class="liMainMenu_link">
                    <i class="fa fa-tag"></i>
                    <span>&nbsp;Product</span>
                    <i class="fa fa-angle-left mainMenuIconArrow ShowHideSubMenu1"></i>
                </a>
                <ul class="subMenus1">
                <li><a href="product-view.php" ><i class="fa fa-circle "></i>View Products</a></li>
                <li><a href="products-add.php"><i class="fa fa-circle"></i>ADD Products</a></li>
                
                </ul>
               <a  class="liMainMenu_link">
                    <i class="fa fa-truck"></i>
                    <span>&nbsp;Supplier</span>
                    <i class="fa fa-angle-left mainMenuIconArrow ShowHideSubMenu2"></i>
                </a>
                <ul class="subMenus2">
                <li><a href="supplier-view.php" ><i class="fa fa-circle "></i>View Suppliers</a></li>
                <li><a href="suppliers-add.php"><i class="fa fa-circle"></i>ADD Supplier</a></li>
                </ul>
                <a  class="liMainMenu_link">
                    <i class="fa fa-shopping-cart"></i>
                    <span>&nbsp;Order</span>
                    <i class="fa fa-angle-left mainMenuIconArrow ShowHideSubMenu3"></i>
                </a>
                <ul class="subMenus3">
                <li><a href="view-order.php" ><i class="fa fa-circle "></i>View Orders</a></li>
                <li><a href="product-order.php"><i class="fa fa-circle"></i>ADD Orders</a></li>
                </ul>
                
                <a  class="liMainMenu_link">
                    <i class="fa fa-user-plus"></i>
                    <span>&nbsp;User</span>
                    <i class="fa fa-angle-left mainMenuIconArrow ShowHideSubMenu4"></i>
                </a>
                <ul class="subMenus4">
                <li><a href="users-view.php" ><i class="fa fa-circle "></i>View Users</a></li>
                <li><a href="users-add.php"><i class="fa fa-circle"></i>ADD User</a></li>
                </ul>
               
        </div>
        </div>

        <!-- Main Content -->
        <div class="dashboard-content">
             <!-- Navigation Bar -->
             <div class="navigation">
                <div class="logout-btn"><a href="logout.php" >Logout<i class="fas fa-sign-out-alt"></i></a></div>
            </div>
            
            
            <!--//////////////////////   List Of Suppliers   ////////////////////////-->
                  
          
           <h1 class="section_header"><i class="fa fa-list"></i> &nbsp;List Of Purshase Orders</h1>
           <div class="section_content">
            <div class="poListContainers">
                <?php 
                  // zedet order_product.received_at bas 
                  // PDO stands for php data object
                  $pdo = new PDO("mysql:host=localhost;dbname=inventory", "root", "");

                  $stmt = $pdo->prepare("SELECT order_product.id,products.product_name,order_product.quantity_ordered,order_product.received_at, users.first_name,
                                        users.last_name,suppliers.supplier_name,order_product.status,order_product.created_at,
                                        order_product.batch,order_product.quantity_received

                                        FROM order_product, suppliers, products, users
                                        WHERE
                                        order_product.supplier = suppliers.id
                                        AND
                                        order_product.product = products.id
                                        AND
                                        order_product.created_by = users.id
                                        ORDER BY order_product.created_at DESC ");
              
                      $stmt->execute();
                      $purchase_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      $data = [];
                       foreach($purchase_orders as $purchase_order){
                        $data[$purchase_order['batch']][] = $purchase_order;
                       }     
                ?>

                <?php 
                foreach($data as $batch_id => $batch_pos){  
                ?>

                <div class="poList" id="container-<?= $batch_id ?>">
                    <p>Batch #:<?php echo "$batch_id"; ?></p>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Qty Ordered</th>
                                <th>Qty Received</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Ordered By</th>
                                <th>Created Date</th>
                                <th>Delivery History</th>
                                <th>Remove Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($batch_pos as $index => $batch_po){
                            ?>
                        <tr>
                                <td><?= $index + 1 ?></td>
                                <td class="po_product alignLeft"><?= $batch_po['product_name'] ?> </td>
                                <td class="po_qty_ordered"><?= $batch_po['quantity_ordered'] ?></td>
                                <td class="po_qty_received"><?= $batch_po['quantity_received'] ?></td>
                                <td class="po_qty_supplier alignleft"><?= $batch_po['supplier_name'] ?></td>
                                <td class="po_qty_status"><span class="po-badge po-badge-<?= $batch_po['status'] ?>"><?= $batch_po['status'] ?></span></td>
                                <td><?= $batch_po['first_name'] . ' ' . $batch_po['last_name']  ?></td>
                                <td>
                                    <?= $batch_po['created_at'] ?>
                                    <input type="hidden" class="po_qty_row_id" value="<?= $batch_po['id'] ?>">
                                </td>
                                <td class="history"><button class="deliveries" onclick="showDeliveryForm('<?= $batch_id ?>')">Deliveries</button></td>

                                <td><button class="removepoBtn" data-id="<?= $batch_po['id'] ?>">Remove</button></td>
                            </tr>
                            <?php } ?>
                         </tbody>
                         </table>

                    <div class="poOrderUpdateBtnContainer" >
                    <button class="updatepoBtn" data-id="<?= $batch_id ?>">Update</button>
                    </div>
                    <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>

 document.addEventListener("DOMContentLoaded", function () {
    // Add click event listener to the main menu links
    const mainMenuLinks = document.querySelectorAll('.liMainMenu_link');

    mainMenuLinks.forEach((link, index) => {
        link.addEventListener('click', function (e) {
            const subMenu = document.querySelector(`.subMenus${index + 1}`);
            const icon = link.querySelector('.mainMenuIconArrow');
            const classList = e.target.classList;

            // Toggle the display of the submenu
            if (subMenu.style.display === 'block') {
                subMenu.style.display = 'none';
                icon.classList.remove('rotateDown');
                link.classList.remove('active'); // Remove active class on hide
            } else {
                // Hide other submenus before displaying this one
                hideOtherSubMenus(`.subMenus${index + 1}`);
                subMenu.style.display = 'block';
                icon.classList.add('rotateDown');
                link.classList.add('active'); // Add active class on display
            }
        });
    });

    function hideOtherSubMenus(currentSubMenu) {
        const allSubMenus = document.querySelectorAll('.subMenus1, .subMenus2, .subMenus3, .subMenus4');
        allSubMenus.forEach(subMenu => {
            if (subMenu !== document.querySelector(currentSubMenu)) {
                subMenu.style.display = 'none';
            }
        });

        const allIcons = document.querySelectorAll('.mainMenuIconArrow');
        allIcons.forEach(icon => {
            if (icon !== document.querySelector(`${currentSubMenu} .mainMenuIconArrow`)) {
                icon.classList.remove('rotateDown');
            }
        });

        const allLinks = document.querySelectorAll('.liMainMenu_link');
        allLinks.forEach(link => {
            if (link !== document.querySelector(`${currentSubMenu.replace('.', '')}Link`)) {
                link.classList.remove('active');
            }
        });
    }

    //Event listener for "update" button

    document.addEventListener('click', function (e) {
        targetElement = e.target;
        classList = targetElement.classList;

        if (classList.contains('updatepoBtn')) {
            e.preventDefault();
            batchNumber = targetElement.dataset.id;
            batchNumberContainer = 'container-' + batchNumber;

            // Get all purchase order product records
            productList = document.querySelectorAll('#' + batchNumberContainer + ' .po_product');
            qtyOrderedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_ordered');
            qtyreceivedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_received');
            supplierList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_supplier');
            statusList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_status');
            rowIds = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_row_id');
            poListArr = [];

            for (i = 0; i < productList.length; i++) {
                poListArr.push({
                    name: productList[i].innerText,
                    qtyOrdered: qtyOrderedList[i].innerText,
                    qtyreceived: qtyreceivedList[i].innerText,
                    supplier: supplierList[i].innerText,
                    status: statusList[i].innerText,
                    id: rowIds[i].value
                });
            }

            // Store in HTML
            var poListHtml = '\
                <table id="formTable_' + batchNumber + '">\
                    <thead>\
                        <tr>\
                            <th>Product Name</th>\
                            <th>Qty Ordered</th>\
                            <th>Qty Received</th>\
                            <th>Supplier</th>\
                            <th>Status</th>\
                        </tr>\
                    </thead>\
                    <tbody>';

            poListArr.forEach((poList) => {
                poListHtml += '\
                    <tr>\
                        <td class="po_product">' + poList.name + '</td>\
                        <td class="po_qty_ordered">' + poList.qtyOrdered + '</td>\
                        <td class="po_qty_received"><input type="number" value="' + poList.qtyreceived + '"/></td>\
                        <td class="po_qty_supplier">' + poList.supplier + '</td>\
                        <td>\
                            <select class="po_qty_status">\
                                <option value="pending" ' + (poList.status == 'pending' ? 'selected' : '') + '>pending</option>\
                                <option value="complete" ' + (poList.status == 'complete' ? 'selected' : '') + '>complete</option>\
                                <option value="incomplete" ' + (poList.status == 'incomplete' ? 'selected' : '') + '>incomplete</option>\
                            </select>\
                            <input type="hidden" class="po_qty_row_id" value="' + poList.id + '">\
                            <input type="hidden" class="po_qty_product_id" value="' + poList.productId + '">\
                        </td>\
                    </tr>';
            });

            poListHtml += '</tbody></table>';

            BootstrapDialog.confirm({
                type: BootstrapDialog.TYPE_PRIMARY,
                title: 'Update Purchase Order: Batch #: <strong>' + batchNumber + '</strong>',
                message: poListHtml,
                callback: function (toAdd) {
                    //if we add
                    if (toAdd) {

                        formTableContainer = 'formTable_' + batchNumber;

                        qtyreceivedList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_received input');
                        statusList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_status');
                        rowIds = document.querySelectorAll('#' + formTableContainer + ' .po_qty_row_id');
                        qtyOrderedList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_ordered');
                        poListArrForm = [];

                        for (i = 0; i < qtyreceivedList.length; i++) {
                            poListArrForm.push({
                                qtyreceived: qtyreceivedList[i].value,
                                status: statusList[i].value,
                                id: rowIds[i].value,
                                qtyOrdered: qtyOrderedList[i].innerText,
                                productId: document.querySelector('#' + formTableContainer + ' .po_qty_product_id').value
                            });
                        }
                        console.log(poListArrForm);
                        //send request / update database
                        $.ajax({
                            type: 'POST',
                            data: {
                                payload: poListArrForm
                            },
                            url: 'update-order.php',
                            dataType: 'json',
                            success: function (data) {
                                if (data.success) {
                                    alert(data.message);
                                    location.reload();
                                } else {
                                    alert(data.message);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX Error:', status, error);
                            }
                        });
                        window.location.href = 'update-order.php';
                    }
                }
            });
        }
    });

///////////////////////////////  Event Listener for "Remove" button  /////////////////////////

$(document).on('click', '.removepoBtn', function (e) {
        e.preventDefault();
        var orderId = $(this).data('id');
        console.log(orderId);
        if (confirm('Are you sure you want to delete this order' )) {
            $.ajax({
                type: 'POST',
                data: { order_id: orderId },
                url: 'delete-order.php',
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        } else {
            console.log('Deletion canceled.');
        }
    });
});
</script>
</body>
</html>

