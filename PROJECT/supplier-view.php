<?php
session_start();

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #dashboardContainer {
            display: flex;
            height: 100vh;
            overflow: auto; /* Enable scrolling */
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background: black;
            color: #f685a1;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-y: auto; /* Enable scrolling for the sidebar */
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
            margin-left: 250px; /* Set this to the width of your sidebar */
           flex: 1;
           padding: 20px;
           background-color: #f685a1;
           color: #fff;
           overflow-y: auto; /* Enable scrolling for the content area */
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
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: auto;
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
            border:1px solid black;
            border-collapse:collapse;
        }
        table{
            width: 100%;
            background-color: lightgrey;
        }
        table th{
            font-size: 12px;
            text-transform: uppercase;
            text-align: center;
            background: #7d7d7d;
            padding:9px;
            border: 1px solid black;
        }
        table td{
            font-size: 12px;
            text-align: center;
            padding: 7px;
            white-space: wrap;
            color: black;
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
       
    </style>
   
    <script>
   document.addEventListener("DOMContentLoaded", function () {
    // Add click event listener to the main menu links
    const mainMenuLinks = document.querySelectorAll('.liMainMenu_link');

    mainMenuLinks.forEach((link, index) => {
        link.addEventListener('click', function () {
            const subMenu = document.querySelector(`.subMenus${index + 1}`);
            const icon = link.querySelector('.mainMenuIconArrow');

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
        const allSubMenus = document.querySelectorAll('.subMenus1, .subMenus2, .subMenus3');
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
});

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
           
                
          
           <h1 class="section_header"><i class="fa fa-list"></i> &nbsp;List Of Suppliers</h1>
           <div class="section_content">
              <div class="users">
               <table>
<thead>
    <tr>
        <th>#</th>
        <th>Supplier Name</th>
        <th>Supplier Location</th>
        <th>Contact Details</th>
        <th>Products</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th >Action</th>
    </tr>
</thead>

<tbody>

    <?php
    $conn = mysqli_connect("localhost", "root", "");
    mysqli_select_db($conn, "inventory");

    $index = 0;

    $select = "SELECT id,supplier_name,supplier_location,email,created_by,created_at,updated_at FROM suppliers";
    $res = mysqli_query($conn, $select);
    
    while ($info = mysqli_fetch_array($res)) {
      
        $id=$info['id'];
        $sname = $info['supplier_name'];
        $sloc = $info['supplier_location'];
        $email = $info['email'];
        $createdBy=$info['created_by'];
        $createdAt = date('M d,Y @ h:i:s A', strtotime($info['created_at']));
        $updatedAt = date('M d,Y @ h:i:s A', strtotime($info['updated_at']));
        $index++;
        echo "<tr>
                 <td>$index</td>
                 <td>$sname</td>
                 <td>$sloc</td>
                 <td>$email</td>"; ?>
              <?php 
              echo "<td>";
             $product_list = '-';
             $id = $info['id']; //id of supplier
         
             try {
                 //PHP Data Objects (PDO) it enables the user to connect to databases regardless their types
                 // Similar to mysqli_connect_db
                 $pdo = new PDO("mysql:host=localhost;dbname=inventory", "root", "");
                 $stmt = $pdo->prepare("SELECT product_name FROM products, productsuppliers WHERE productsuppliers.supplier = :id AND productsuppliers.product = products.id");
                 $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                 
                 $stmt->execute();
                 $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 
                 if ($products) {
                     $product_arr = array_column($products, 'product_name');
                     $product_list = implode(", ", $product_arr);
                 }
             } catch (PDOException $e) {
                 die("Error: " . $e->getMessage());
             }
             
             echo $product_list;
             echo "</td>";
                 
                  echo"<td>$createdBy</td>
                 <td>$createdAt</td>
                 <td>$updatedAt</td>
                 <td>
                 <a href='update-supplier.php?supplier_id=$id' class='editSupplier' data-supplierid='$id' data-sname='$sname' data-sloc='$sloc' data-email='$email'> <i class='fa fa-pencil'></i> Edit<br></a> 
                 <a href='delete-supplier.php?supplier_id=$id' class='deleteSupplier' data-supplierid='$id' data-sname='$sname'><i class='fa fa-trash'></i> Delete</a>
                  </td>
               </tr>";
            }
             ?>
            </tbody>

               </table>
                <p class="userCount"><?php echo"$index ";?>Suppliers</p>
              </div>
           </div>
           </div>
        </div>
    </div>
 </div>
 </div>

 <!-- /////////////// edit container for the supplier /////////////////////////////-->

 <div id="editFormContainer" style="display: none;">
 <button type="button" id="closeEditForm" style="float: right; font-size: 20px; margin-right: 10px;">&times;</button>
    <form id="editForm" action="update-supplier.php" method="post">
     
    <div>
    <input type="hidden" id="editSupplierId" name="supplier_id" readonly>
    </div>

        <div>
            <label for="editSupplierName"><b>Supplier Name</b></label>
            <input type="text" id="editSupplierName" name="editsupplier_name">
        </div>
        <div>
            <label for="editSupplierLocation"><b>Supplier Location</b></label>
            <input type="text" id="editSupplierLocation" name="editsupplier_location">
        </div>
        <div>
            <label for="editEmail"><b>Email</b></label>
            <input type="text" id="editEmail" name="editemail">
        </div>
        <button type="button" id="editOkBtn" name="editOkBtn">OK</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

$(document).ready(function () {

////////////////////////          Event listener for "Delete" links          /////////////////////////

$(document).on('click', '.deleteSupplier', function (e) {
    e.preventDefault();
    var supplierId = $(this).data('supplierid');
    var sname = $(this).data('sname');

    if (confirm('Are you sure you want to delete ' + sname + '?')) {
        $.ajax({
            type: 'POST',
            url: 'delete-supplier.php',
            data: { supplier_id: supplierId },
            dataType: 'json',
            success: function (data) {
                if (data.success) {
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

//////////////////////////////      for the edit       ///////////////////////////////////////


// Event listener for "Edit" links
$(document).on('click', '.editSupplier', function (e) {
    e.preventDefault();

    var supplierId = $(this).data('supplierid');
    var sname = $(this).data('sname');
    var sloc = $(this).data('sloc');
    var email = $(this).data('email');

    // Assuming you have a form with ID 'editForm' and input fields with IDs 'editSupplierName', 'editSupplierLocation', and 'editEmail'
    $('#editSupplierId').val(supplierId);
    $('#editSupplierName').val(sname);
    $('#editSupplierLocation').val(sloc);
    $('#editEmail').val(email);

    // Show the edit form
    $('#editFormContainer').show();
});

// Event listener for closing the edit form
$('#closeEditForm').click(function () {
    // Hide the edit form
    $('#editFormContainer').hide();
});

// Event listener for "OK" button in edit form
$('#editOkBtn').click(function () {
    var supplierId = $('#editSupplierId').val();
    var supplierName = $('#editSupplierName').val();
    var sloc = $('#editSupplierLocation').val();
    var email = $('#editEmail').val();

    $.ajax({
        type: 'POST',
        data: {
            supplier_id: supplierId,
            supplier_name: supplierName,
            supplier_location: sloc,
            email: email
        },
        url: 'update-supplier.php',
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

    // Hide the edit form
    $('#editFormContainer').hide();
});
});

</script>

</body>
</html>