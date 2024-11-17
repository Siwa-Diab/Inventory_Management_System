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
           margin-left: 250px; /* Set this to the width of the sidebar */
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
            white-space: nowrap;
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
            left: 30%;
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
            font-size: 19px ;/* !important after a CSS property value, it signifies that this particular style should take precedence over other conflicting styles, regardless of their specificity*/
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
               <a class="liMainMenu_link">
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

            <!--/ / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / / /-->          
                
          
           <h1 class="section_header"><i class="fa fa-list"></i> &nbsp;List Of Users</h1>
           <div class="section_content">
              <div class="users">

<table>                          <!-- Inside the thead section of the table -->
<thead>
    <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
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
    
    $select = "SELECT id,first_name,last_name,email,created_at,updated_at FROM users";
    $res = mysqli_query($conn, $select);
    
    while ($info = mysqli_fetch_array($res)) {
       
        $id=$info['id'];
        $fname = $info['first_name'];
        $lname = $info['last_name'];
        $email = $info['email'];
        $createdAt = date('M d,Y @ h:i:s A', strtotime($info['created_at']));
        $updatedAt = date('M d,Y @ h:i:s A', strtotime($info['updated_at']));
        $index++;

        echo "<tr>
                 <td>$index</td>
                 <td>$fname</td>
                 <td>$lname</td>
                 <td>$email</td>
                 <td>$createdAt</td>
                 <td>$updatedAt</td>
                
                 <td >

                 <!-- wara l ? ya3ne khedle yehon lama okbos l edit aw delete w mnesta3melon bl javascript ta7didan bl jquery -->

                 <a href='update-user.php?user_id=$id'class='editUser' data-userid='$id' data-fname='$fname' data-lname='$lname' data-email='$email'> <i class='fa fa-pencil'></i> Edit<br></a> 
                 <a href='delete-user.php?user_id=$id'class='deleteUser'data-userid='$id' data-fname='$fname' data-lname='$lname'><i class='fa fa-trash'></i> Delete</a>

                 </td>
              </tr>";
    }
    ?>
</tbody>
</table>
         <p class="userCount"><?php echo"$index ";?>Users</p>
              </div>
            </div>
          </div>
       </div>
     </div>
   </div>
 </div>
 
 <!-- ///////  THE FORM THAT POPS FOR EDITING //////////////-->

 <div id="editFormContainer" style="display: none;">
 <button type="button" id="closeEditForm" style="float: right; font-size: 20px; margin-right: 10px;">&times;</button>
    <form id="editForm" action="update-user.php" method="post">
        <input type="hidden" id="editUserId" name="user_id" value=$id>
        <div>
            <label for="editFirstName"><b>First Name</b></label>
            <input type="text" id="editFirstName" name="editfirst_name">
        </div>
        <div>
            <label for="editLastName"><b>Last Name</b></label>
            <input type="text" id="editLastName" name="editlast_name">
        </div>
        <div>
            <label for="editEmail"><b>Email</b></label>
            <input type="text" id="editEmail" name="editemail">
        </div>
        <button type="button" id="editOkBtn" name="editOkBtn">OK</button>
    </form>
</div>

<!--It is a javascript library that allows us to use ajax requests -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
   $(document).ready(function () {

    //Event listener for "Delete" links
    $(document).on('click', '.deleteUser', function (e) {
        e.preventDefault(); //prevents moving to a new page after clicking the delete link

        var userId = $(this).data('userid');
        var fname = $(this).data('fname');
        var lname = $(this).data('lname');
        var fullName = fname + ' ' + lname;

        if (confirm('Are you sure you want to delete ' + fullName + '?')) {
            // AJAX request allows to transform data from javascript to be used in php
            $.ajax({
                type: 'POST', // method
                data: { user_id: userId }, //object data
                url: 'delete-user.php', // go to thsi page
                dataType: 'json', // Expects a JSON response from the server.
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
        } 
    });

    ///////////////////////////////////      for the edit      /////////////////////////////////////////////

    // Event listener for "Edit" links
    $(document).on('click', '.editUser', function (e) {
            e.preventDefault();//prevents moving to a new page after clicking the edit link

            var userId = $(this).data('userid');
            var fname = $(this).data('fname');
            var lname = $(this).data('lname');
            var email = $(this).data('email');

            // Assuming we have a form with ID 'editForm' and input fields with IDs 'editFirstName', 'editLastName', and 'editEmail'
            $('#editUserId').val(userId);
            $('#editFirstName').val(fname);
            $('#editLastName').val(lname);       //kl shi id b7otello abel #
            $('#editEmail').val(email);

            // Show the edit form
            $('#editFormContainer').show(); // hayde l id lal form kella
        });
    
              // Event listener for closing the edit form
        $('#closeEditForm').click(function () {
        // Hide the edit form
          $('#editFormContainer').hide();
         });

        // Event listener for "OK" button in edit form
        $('#editOkBtn').click(function () {
           
            var userId = $('#editUserId').val();
            var firstName = $('#editFirstName').val();
            var lastName = $('#editLastName').val();
            var email = $('#editEmail').val();

            $.ajax({
                type: 'POST',
                data: { // 2e5din kl shi badna na3melo update
                    user_id: userId,
                    first_name: firstName,
                    last_name: lastName,
                    email: email
                },
                url: 'update-user.php',
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
<?php 
    if(isset($_POST['editOkBtn']))
    header('Location: update-user.php');
 ?>
</script>
</body>
</html>