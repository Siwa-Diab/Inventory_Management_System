
<?php 
session_start();

$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch values from session
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Advanced Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="js/script.js"></script>
   <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #dashboardContainer {
            display: flex;
            height: 150vh;
            margin-left: 19.75%;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: black; /* Match the logo color */
            color: #f685a1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position:fixed;
            top: 0; /* Set the top position to 0 */
            left: 0; /* Set the left position to 0 */
            height: 100%; /* Set the height to 100% to cover the entire height of the viewport */
            overflow-y: auto; /* Add vertical scroll if the content overflows*/
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
        #container { /* for the pie*/
            width: 100%;
            height: 400px; /* You can adjust the height as needed */
            margin: 20px 0; /* Add some margin for spacing */
           
        }
        #containerBarChart { /* for the pie*/
            width: 100%;
            height: 400px; /* You can adjust the height as needed */
            margin: 20px 0; /* Add some margin for spacing */
        }
        div.col50{
            width: 50%;
            box-sizing: border-box; /* Include padding and border in the width calculation */
            float: left; /* Float the columns to the left */
            padding: 0 10px; /* Optional padding for better spacing */
        }
        
        #reportsContainer {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            
        }
        .reportType{
         border: 1px solid #333;
         padding: 10px 24px;
         border-radius: 4px;
         border-color: #333;
         background: #fff;
         font-size: 14px;
         color: #333;
         margin-left: 21px;
         width: 60%;
         margin-top: 5%;
         margin-left: 15%;
        }
        .reportType:hover{
            background: #763a49;
            color: #fff;
        }
        .alignRight{
            text-align: right;
        }
        .reportExportBtn{
            padding: 4px 15px;
            display: inline-block;
            text-decoration: none;
            text-transform: uppercase;
            background: #f685a1;
            color: white;
            margin-right: 13px;
            font-size: 11px;
            border: 1px solid transparent;
        }
        .reportExportBtn:hover{
            border: 1px solid #f685a1;
            background: #fff;
            color: #f685a1;
        }
        .reportType p{
            font-size: 20px;
            font-weight: 200;
            margin-bottom: 5px;
        }
        .reportExportBtn {
            padding: 4px 15px;
            display: inline-block;
            text-decoration: none;
            text-transform: uppercase;
            color: white;
            font-size: 11px;
            border: 1px solid transparent;
        }

        .reportExportBtn:hover {
            border: 1px solid #f685a1; /* Change border color to the PDF button color */
         }

       .reportExportBtn.excel {
            background: #4CAF50; /* Green color for Excel button */
        }

        .reportExportBtn.pdf {
           background: #FF0000; /* Red color for PDF button */
        }

       .reportExportBtn.excel:hover {
          background: #fff;
          color: #4CAF50;
        }
 
       .reportExportBtn.pdf:hover {
         background: #fff;
         color: #FF0000; 
        }
    </style>
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
               <a href="javascript:void(0);" class="liMainMenu_link">
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
            <div id="reportsContainer">
            <div class="reportTypeContainer">
             <div class="reportType">
                <p>Export Products</p>
                <div class="alignRight">
                    <a href="report_csv.php?report=product" class="reportExportBtn excel">Excel</a>
                    <a href="report_pdf.php?report=product" target="_blank" class="reportExportBtn pdf">PDF</a>
                </div>
             </div>
             <div class="reportType">
                <p>Export Suppliers</p>
                <div class="alignRight">
                    <a href="report_csv.php?report=supplier" class="reportExportBtn excel">Excel</a>
                    <a href="report_pdf.php?report=supplier" target="_blank" class="reportExportBtn pdf">PDF</a>
                </div>
             </div>
             </div>
             <div class="reportType">
                <p>Export Purchase Orders</p>
                <div class="alignRight">
                    <a href="report_csv.php?report=purchase_orders" class="reportExportBtn excel">Excel</a>
                    <a href="report_pdf.php?report=purchase_orders" target="_blank" class="reportExportBtn pdf">PDF</a>
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
</body>
</html>