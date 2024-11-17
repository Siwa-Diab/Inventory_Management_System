<?php
session_start();

$_SESSION['table'] = 'products';
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
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: black; /* Match the logo color */
            color: #f685a1;
            display: flex;
            flex-direction: column;
            align-items: center;
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
        form.appForm{        /* for the entire form */
            width:100%;
            margin: 0 ;
            padding: 15px;
            border:2px solid black;
            border-radius:5px ;
            margin-top:30px;
            margin-left: 3%;
            background-color: lightgray;
            color: black;
            margin-bottom:10px;
             
        }
        form label{              /*for the label */
            font-weight: bold;
            text-transform: uppercase;
        }
        form input.appFormInput{   /*for the inputs */
            width:100%;
            height: 30px;
            border: 1px solid black;
            border-radius: 5px;
            color: black;
        }
        div.appFormInputContainer{
            margin-bottom: 15px;
        }
      
        div.row{
            display: flex;    /*applied to the container element (the parent) */
            flex-direction: row;   /* main axis to be horizontal (from left to right) */
            flex-wrap: wrap;      /* allows items to wrap to the next line if there isn't enough space on the current line*/
            width: 100%;
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
            font-size: 19px !important;/* !important after a CSS property value, it signifies that this particular style should take precedence over other conflicting styles, regardless of their specificity*/
            margin-left: 7px;
            transition: transform 0.3s; /* Added transition property for smooth animation */
        }

        i.rotateDown {
            transform: rotate(-90deg); /* Rotates the icon 90 degrees */
        }
        a.liMainMenu_link.active {
            background-color: #f685a1;
        }
        
        #suppliersSelect{
            display: block;
            width: 100%;
            height: 60px;
            border-color: #d2d2d2;
        }
        /* Add new styles here for product selection */
        #addProductBtn {
            width: 50%;
            background: red;
            border: 2px solid red;
            border-radius: 10px;
            color: #fff;
            padding: 10px;
            margin-top: 60px;
            font-weight: bold;
            float:none;
            clear:both;
        }

        #addProductBtn:hover {
            border: 2px solid black;
            transition: 0.2s;
        }

        .productSelection {
            margin-top: 20px;
        }

        .productSelection label,
        .productSelection span,
        .productSelection button {
            margin-bottom: 10px;
        }
        .productSelection label {
          display: block;
          margin-bottom: 5px;
        }

        .productSelection select,
        .productSelection input {
          width: 100%;
          height: 30px;
          border: 1px solid black;
          border-radius: 5px;
          margin-bottom: 10px;
          color: black;
        }

     .productSelection button {
         background-color: orange;
         color: #fff;
         border: none;
         padding: 5px 10px;
         border-radius: 5px;
         cursor: pointer;
         margin-top: 10px; /* Adjusted margin */
        }

     .productSelection button:hover {
        background-color: #d45f00;
        }
     
     body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #orderAddFormContainer {
            width: 80%;
            margin: 20px auto;
            
        }

        form.appForm {
            width: 70%;
            margin: 0;
            padding: 15px;
            border: 2px solid black;
            border-radius: 5px;
            background-color: lightgray;
            color: black;
            margin-bottom: 10px;
            margin-left: 25px;
        }

        form label {
            font-weight: bold;
            text-transform: uppercase;
        }

        form select,
        form input {
            width: 100%;
            height: 30px;
            border: 1px solid black;
            border-radius: 5px;
            margin-bottom: 10px;
            color: black;
        }

        form button {
            background: red;
            color: #fff;
            padding: 10px;
            border: 2px solid red;
            border-radius: 10px;
            cursor: pointer;
            float: right;
        }

        form button:hover {
            border: 2px solid black;
            transition: 0.2s;
        }
        .productSelection {
            display: none; /* Initially hide the product selection container */
            margin-top: 20px;
            padding: 15px;
            border: 2px solid #f685a1;
            border-radius: 10px;
        }
         .productSelection label,
         .productSelection span,
         .productSelection button {
          margin-bottom: 10px;
         }

        #noProductsSelected {
            margin-left: 20px;
        }

        /* Add this style for the submit button color */
#submitOrderBtn {
    background-color: #f685a1;
    color: #fff;
    border: 2px solid #f685a1; /* Add border for a cleaner look */
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

#submitOrderBtn:hover {
    background-color: #d96891; /* Slightly darker color on hover */
}

/* Add this style for the error message */
#errorMsg {
    color: red;
    margin-top: 10px;
    font-weight: bold;
}
/* Add this style to control the layout of Supplier label and span */
.supplierContainer {
    display: flex;
    align-items: center;
}


   .supplierContainer,
      label[for="quantity"] {
      margin-bottom: 5px; /* Adjusted margin for better spacing */
   }
    /* Container for the form with scroll */
      #orderAddFormContainer {
            overflow-y: auto; /* Add a vertical scrollbar if the content overflows */
            max-height: 65vh; /* Set a maximum height for the container */
        }

        .supplier-info {
          margin-left: 15px; /* You can adjust the value as needed */
          color:black;
          border-bottom: 2px solid red; /* Adjust the color as needed */
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
            <!--/////////////////////////    kl shi fo2 bidal nafs l shi    //////////////////////////////////////////-->


            <div class="row">
                <h3 class="section_header"><i class="fa fa-plus"></i> &nbsp;Order Product</h3>
            
                 <!-- Add Another Product button -->
                 <button type="button" name="AddAnotherProduct" value="AddAnotherProduct" id="addProductBtn">Add Another Product</button>


                  <!-- Container for adding a product order -->
            <div id="orderAddFormContainer">
            <form action="save-order.php" method="post" class="appForm" enctype="multipart/form-data"> 
            <div class="productSelection">
                <label for="productName">Product Name  </label>
                <select  name="products[]" id="productName" onchange="getSupplierInfo(this.value)">
                <?php 
                echo"<option value='0'>Select Product</option>";
                $conn = mysqli_connect("localhost", "root", "");
                mysqli_select_db($conn, "inventory");
                if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }
               $q="SELECT id,product_name FROM products";
               $r=mysqli_query($conn,$q);
               while($product=mysqli_fetch_array($r)){
               echo"<option value=' ". $product['id'] ." '>".$product['product_name']."</option>";
               $products[] = $product; // Store the product in the array
               }
                 // Store the products array in the session variable
                 $_SESSION['products'] = $products;
                ?>
                </select>
               

                <div class="supplierContainer">
                <label for="supplier"><br>Supplier </label>
                 <span id="supplier" class="supplier-info">
                </span>
                </div>

                <label for="quantity"><br>Quantity </label>
                <input type="text" id="quantity" name="quantity" placeholder="Enter Quantity">
            </div>

            <button type="submit" id="submitOrderBtn">Submit Order</button>
             <!-- No products selected message -->
             <div id="noProductsSelected">No products selected</div>
            
            <!-- Error message -->
            <div id="errorMsg"></div>
        </form>
        <?php 
           if(isset($_SESSION['response'])) {
            $response_message= $_SESSION['response']['message'];
            $is_success= $_SESSION['response']['success'];
          ?>
             <div class="responseMessage">
                <p div class="responseMessage">
                 <?php echo" $response_message"; ?>
            </p>
             </div>
          <?php unset($_SESSION['response']); }  ?>
    </div>
    </div>
    </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    // Add click event listener to the "Add Another Product" button
    const addProductBtn = document.getElementById('addProductBtn');
    addProductBtn.addEventListener('click', function () {
        // Toggle the display of the product selection container
        const productSelection = document.querySelector('.productSelection');
        productSelection.style.display = 'block';

         // Hide the "No products selected" message when a product is selected
         const noProductsSelected = document.getElementById('noProductsSelected');
        noProductsSelected.style.display = 'none';
    });

    // Add submit event listener to the form
    const orderForm = document.querySelector('.appForm');
    orderForm.addEventListener('submit', function (event) {
        // Get the selected product and quantity
        const productNameSelect = document.getElementById('productName');
        const quantityInput = document.getElementById('quantity');

        // Check if a product is selected and quantity is specified
        if (productNameSelect.value === '0' || quantityInput.value.trim() === '') {
            // Display the error message
            const errorMsg = document.getElementById('errorMsg');
            errorMsg.textContent = "You have to select a product and specify its quantity before submitting";

            // Prevent the form from submitting
            event.preventDefault();
        }
    });

      // Add change event listener to the product selection dropdown
      const productNameSelect = document.getElementById('productName');
        productNameSelect.addEventListener('change', function () {
        // Show or hide the "No products selected" message based on whether a product is selected
        const noProductsSelected = document.getElementById('noProductsSelected');
        noProductsSelected.style.display = productNameSelect.value === '0' ? 'block' : 'none';
    });
});

function getSupplierInfo(productId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_suppliers.php?product_id=' + productId, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const supplierInfo = JSON.parse(xhr.responseText);

            // Update the supplier span with the retrieved information
            const supplierSpan = document.getElementById('supplier');
            supplierSpan.textContent = supplierInfo;
        }
    };
    xhr.send();
}
</script>
</body>
</html>