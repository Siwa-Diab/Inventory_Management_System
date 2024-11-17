<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

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
       div#userAddFormContainer{
            padding-top: 0px;
        }
        button.appBtn{          /* for the button(Add User) */
           width:50%;
            background:red;
           border: 2px solid red;
           border-radius: 10px;
           color: #fff;
           padding: 10px;
           margin-top: 20px;
           font-weight: bold;
           float: right;        /* positioned the button to the right */
        }
        .appBtn:hover{
          border:2px solid black;
          transition: 0.2s;
        }
        p.responseMessage{  /* style the message after inserting*/
          font-size: 18px;
          text-align: center;
          margin-top: 10px;
          background: lightblue;
          padding: 20px;
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
            font-size: 19px ;/* !important after a CSS property value, it signifies that this particular style should take precedence over other conflicting styles, regardless of their specificity*/
            margin-left: 7px;
            transition: transform 0.3s; /* Added transition property for smooth animation */
        }

        i.rotateDown {
            transform: rotate(-90deg); /* Rotates the icon 90 degrees */
        }
        a.liMainMenu_link.active {
            background-color: #f685a1;
        }
        .appFormInputContainer textarea {
            width: 97.5%;
            border: 1px solid black;
            border-radius: 5px;
            padding: 5px;
            resize: vertical;
            color: black;
            font-size: 14px;
            margin-bottom: 5px; /* Add margin for spacing between elements */
        }

        .appFormInputContainer input[type="file"] { /* for the image */
           padding: 10px; /* Add padding for better appearance */
           width: 100%;
           height: 35px; /* Adjust height as needed */
           margin-bottom:-60px; /* Add margin for spacing between elements */
        }
        #suppliersSelect{
            display: block;
            width: 100%;
            height: 60px;
            border-color: #d2d2d2;
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
            
               <a href="javascript:void(0);" class="liMainMenu_link">
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
                <a href="javascript:void(0);" class="liMainMenu_link">
                    <i class="fa fa-shopping-cart"></i>
                    <span>&nbsp;Order</span>
                    <i class="fa fa-angle-left mainMenuIconArrow ShowHideSubMenu3"></i>
                </a>
                <ul class="subMenus3">
                <li><a href="view-order.php" ><i class="fa fa-circle "></i>View Orders</a></li>
                <li><a href="product-order.php"><i class="fa fa-circle"></i>ADD Orders</a></li>
                </ul>
                
                <a href="javascript:void(0);" class="liMainMenu_link">
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
            <!--///////////////////////////////////////////////////////////////////-->


            <div class="row">
                <h3 class="section_header"><i class="fa fa-plus"></i> &nbsp;Create Product</h3>

                <div id="userAddFormContainer">
        
                <form action="product-add.php" method="post" class="appForm" enctype="multipart/form-data">
  
    <div class="appFormInputContainer">
    <label for="product_name">Product Name</label>
    <input type="text" class="appFormInput" id="product_name" placeholder="Enter product name..." name="product_name" value="">
</div>

<div class="appFormInputContainer">
    <label for="description">Description</label>
    <textarea class="appFormInput productTextAreaInput"  id="description" placeholder="Enter product description..." name="description" value="">
    </textarea>
</div>
<div class="appFormInputContainer">
    <label for="suppliers">Suppliers</label>
    <select name="supplier"  id="suppliersSelect" size="3">
         <?php

          $_SESSION['suppliers']=$_POST['supplier'];

          $conn = mysqli_connect("localhost", "root", "");
          mysqli_select_db($conn, "inventory");
         
          if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
         }

          $q="SELECT id,supplier_name FROM suppliers";
          $r=mysqli_query($conn,$q);
         
          while($supplier=mysqli_fetch_array($r)){
            echo"<option value=' ". $supplier['id'] ." '>".$supplier['supplier_name']."</option>";
             $_SESSION['supplier_id']=$supplier['id'];
          }
         ?>  
    </select>

</div>
<div class="appFormInputContainer">
    <label for="product_name">Product Image</label>
    <input type="file" name="img"><!--type is file to choose an image from it-->
</div>
    <button type="submit" class="appBtn"><i class="fa fa-plus"></i> &nbsp;Create Product</button>
    </form>
</div>
</div>
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
    </div>
  </div>
</body>
</html>