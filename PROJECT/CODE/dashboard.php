
<?php 
session_start();

// Check if the user is not logged in ( hayda l id tba3 l user )
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetch values from session
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : ''; 
// if the value of the the firstname of the user was set take its value else let $first_name take the value of nothing

$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';

//Get graph data-purchase order by status
include('po_status_pie_graph.php');

//Get graph-supplier-product count
include('supplier_product_bar_graph.php');
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
           overflow-y: auto; /* Enable scrolling for the content area *//
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
               
                <a  class="liMainMenu_link">
                    <i class="fa fa-tag"></i>
                    <span>&nbsp;Product</span>
                    <i class="fa fa-angle-left mainMenuIconArrow ShowHideSubMenu1"></i>
                </a>
                <ul class="subMenus1">
                <li><a href="product-view.php" ><i class="fa fa-circle "></i>View Products</a></li>
                <li><a href="products-add.php"><i class="fa fa-circle"></i>ADD Products</a></li>
                </ul>
               <a class="liMainMenu_link">
                    <i class="fa fa-truck"></i>
                    <span>&nbsp;Supplier</span>
                    <i class="fa fa-angle-left mainMenuIconArrow ShowHideSubMenu2"></i>
                </a>
                <ul class="subMenus2">
                <li><a href="supplier-view.php" ><i class="fa fa-circle "></i>View Suppliers</a></li>
                <li><a href="suppliers-add.php"><i class="fa fa-circle"></i>ADD Supplier</a></li>
                </ul>
                <a class="liMainMenu_link">
                    <i class="fa fa-shopping-cart"></i>
                    <span>&nbsp;Order</span>
                    <i class="fa fa-angle-left mainMenuIconArrow ShowHideSubMenu3"></i>
                </a>
                <ul class="subMenus3">
                <li><a href="view-order.php" ><i class="fa fa-circle "></i>View Orders</a></li>
                <li><a href="product-order.php"><i class="fa fa-circle"></i>ADD Orders</a></li>
                </ul>
                
                <a class="liMainMenu_link">
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
            
            
            <!-- Dashboard Content Goes Here -->
            <h1>Welcome to Dashboard!</h1>
            <div class="col50">
        <div id="containerBarChart">

      <!-- These are links used for the bar graph and the pie chart-->  

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
   
    <script>
        var barGraphData = <?= json_encode($bar_chart_data) ?>; //li 3emlina bi2alb l supplier_product_bar_graph
                                                                // bi2alba counter la yzeed l bars kl ma zeed l supplier
        var   barGraphCategories = <?= json_encode($categories) ?>;

        // json_encode is usd to transform the php array $categories into a JSON array to be used later in javascript
        // JavaScript Object Notation
       
         Highcharts.chart('containerBarChart', {

          chart: { /* This one is for the bar graph*/
              type: 'column'
      },
          title: {
               text: 'Product Count Assigned To Supplier',
               align: 'left'
      },
          xAxis: {
               categories: barGraphCategories, // li hiyye l suppliers names li 5azaneha 
               crosshair: true, // When you hover above a bar it creates a shadow behind it.
      },
          yAxis: {
               min: 0,
               title: {
               text: 'Product Count'
         }
      },
      // when i hover above any bar the suppliers name is presented followed by : then the number of products it has.
         tooltip: {
              pointFormatter: function () {
              var point = this,
              series = point.series;
              return '<b>' + point.category + '</b>: ' + point.y; // l y hiyye l count mn l bar_graph.php 
                                                                  //and the category is the supplier names array
            
         }
      },

       plotOptions: {
          column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
  },
       series: [
       {
         name: 'Suppliers', // hiyye l klme li btbayin ta7t l bargraph
         data: barGraphData
    },]
});

</script>

</div>    
</div>

  <!-- ////////////////////////////////////////// PIE CHART CODE /////////////////////////////////////////-->

            <div class="col50">

    <div id="container"></div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    
    <script>

    var graphData = <?= json_encode($results) ?>;
    // $results contains the name (incomplete / complete / pending) and the value of it.
    Highcharts.chart('container', {
        
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: true,
            type: 'pie'
        },

        title: {
            text: 'Purchase Orders By Status',
            align: 'left'
        },

        tooltip: {
            pointFormatter: function () { 
                var point = this,
                    series = point.series;
                return '<b>' + series.name + '</b>: ' + point.y;
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
               
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}'// the arrow that points to each status 
                }
            }
        },
        series: [{
            name: 'Status', 
            colorByPoint: true,
            data: graphData
        }]
    });
</script>

<p class="highcharts-description">Here is the breakdown of the purchase orders by status.</p>
</div>
</div>
</div>
    
<script>

   document.addEventListener("DOMContentLoaded", function () {
    // Add click event listener to the main menu links

    const mainMenuLinks = document.querySelectorAll('.liMainMenu_link'); // kl li 3endon hayda l class 3am 7otton bi mainMenuLinks

    mainMenuLinks.forEach((link, index) => {

        link.addEventListener('click', function () {
            const subMenu = document.querySelector(`.subMenus${index + 1}`); //index +1 la7ata yemshe bikel submenu.
            const icon = link.querySelector('.mainMenuIconArrow');

            // Toggle the display of the submenu
            //if we didnt click on any submenu dont put an active background and dont rotate the arrow down
            if (subMenu.style.display === 'block') {
                subMenu.style.display = 'none';
                icon.classList.remove('rotateDown'); //rotateDown is a function found in the css
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