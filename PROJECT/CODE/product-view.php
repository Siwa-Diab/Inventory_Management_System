<?php
session_start();

// connect to the database normally
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch values from session
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$last_name  = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';


if (isset($_POST['editOkBtn'])) {
    header('Location: update-product.php');
    exit();
}

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
            background-color: #f685a1; /* Background color behind "Welcome to Dashboard!" */
            color: #fff; /* Text color */
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
            color: #7d7d7d;
            border-bottom: 1px solid black;
            padding-bottom: 11px;
            padding: 10px;
            border-left:4px solid black ;
            margin-bottom: 15px;
             
        }
        /* Adjust the border properties to make it shorter */
        h2.section_header:after {
            content: "";
            display: block;
            border-bottom: 1px solid black; /* New border properties for the line underneath */
            margin-top: 20px; /* Adjust the margin to control the length of the line */
            color:#fff; 
           
            
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
            top: 85px;
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
        
        #editSuppliersSelect {
         width: 100%;
         padding: 5px; /* Add padding for better appearance */
         box-sizing: border-box; /* Include padding and border in the element's total width and height */
         appearance: none; /* Remove default arrow icon in some browsers */       
        }

        #editDescription {
         width: 85%;
         height: 66px; /* Set the desired fixed height */
         box-sizing: border-box; /* Include padding and border in the element's total width and height */
         resize: none; /* Disable resizing, preventing users from changing the height */
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
        table td img {
            width: 50px;
            height: 50px;
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
        const allSubMenus = document.querySelectorAll('.subMenus1, .subMenus2, .subMenus3, .submneu4');
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
        
        
            <!--////////////////   PRODUCTS LIST    //////////////////////////////-->
           
                  
           <h2 class="section_header"><i class="fa fa-list"></i> &nbsp;List Of Products</h2>
           <div class="section_content">
              <div class="users">

            <table> 
            <thead>
                 <tr>
                 <th>#</th>
                 <th>Image</th>
                 <th>Product Name</th>
                 <th>Description</th>
                 <th>Suppliers</th>
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
 
   // LEFT JOIN means taking the common things with the first table 
   $select = "SELECT
        products.id AS product_id,
        products.img,
        products.product_name,
        products.description,
        products.created_by,
        products.created_at,
        products.updated_at,
        GROUP_CONCAT(suppliers.supplier_name SEPARATOR ', ') AS suppliers
    FROM
        products
    LEFT JOIN
        productsuppliers ON products.id = productsuppliers.product
    LEFT JOIN
        suppliers ON productsuppliers.supplier = suppliers.id
    GROUP BY
        products.id";
   
    $res = mysqli_query($conn, $select);
    
    while ($info = mysqli_fetch_array($res)) {
       
         $id=$info['product_id'];
         $_SESSION['product_id']=$id;
         $img =$info['img'];
         $pname = $info['product_name'];
         $desc = $info['description'];
         $created_by=$info['created_by'];
         $createdAt = date('M d,Y @ h:i:s A', strtotime($info['created_at']));
         $updatedAt = date('M d,Y @ h:i:s A', strtotime($info['updated_at']));
         $index++;

        echo "<tr>
        <td>$index</td>
        <td><img src='./IMAGES/$img' alt=''></td>
        <td>$pname</td>
        <td>$desc</td>
        <td>";

       // Correctly display the suppliers in the Suppliers column
    
       $pid = $info['product_id'];
      
     try {
        // PHP Data Objects  =>PDO (badna l supplier li 5aso bl product li na2ayne)
        $pdo = new PDO("mysql:host=localhost;dbname=inventory", "root", "");
        $stmt = $pdo->prepare("SELECT supplier_name FROM suppliers, productsuppliers WHERE productsuppliers.product = $pid AND productsuppliers.supplier = suppliers.id");
                                                                                                                            // a5adet l supplier l moshtarak ben l tnen tables                            
        $stmt->execute();
        $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // iza ken 3enna kaza supplier la product m7adad befselon bi fasle
        if ($suppliers) {
            $supplier_arr = array_column($suppliers, 'supplier_name');
            $supplier_list = implode(", ", $supplier_arr);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    echo "$supplier_list</td>
        <td>$created_by</td>
        <td>$createdAt</td>
        <td>$updatedAt</td>
        <td>
            <a href='update-product.php?product_id=$id' class='editProduct' data-productid='$id' data-pname='$pname' data-desc='$desc' data-suppliers='$supplier_list' data-img='$img'><i class='fa fa-pencil'></i> Edit<br></a>
            <a href='delete-product.php?product_id=$id' class='deleteProduct' data-productid='$id' data-pname='$pname'><i class='fa fa-trash'></i> Delete</a>
        </td>
    </tr>";
}
?>
               </tbody>
               </table>

                <p class="userCount"><?php echo"$index ";?>Products</p>
              </div>
           </div>
          </div>
        </div>
      </div>
    </div>
 </div>

<!-- ////////////////////////   Edit Form /////////////////////////////// -->

 <div id="editFormContainer" style="display: none;">
 <button type="button" id="closeEditForm" style="float: right; font-size: 20px; margin-right: 10px;">&times;</button>
    <form id="editForm" action="update-product.php" method="post" enctype="multipart/form-data">
       <input type="hidden" id="editProductId" name="editproduct_id" value="">

        <div>
            <label for="editProductName"><b>Product Name</b></label>
            <input type="text" id="editProductName" name="editproduct_name" value="">
        </div>
        <div>
            <label for="editSupplier"><b>Choose Supplier</b></label>
            <select name="suppliers" id="editSuppliersSelect"size="3">

        <!-- Hon 3am 3abe l values lal options li bi2alb l select supplier-->

        <?php 
         
         $conn = mysqli_connect("localhost", "root", "");
         mysqli_select_db($conn, "inventory");
         
         if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
        }

         $q="SELECT id,supplier_name FROM suppliers";
         $r=mysqli_query($conn,$q);

         // kl option mawjude ela value li howe l id te3ula la 2e2dar ba3den shufa iza moshtarake ben l products w supplier bl productsuppliers table
         while($supplier=mysqli_fetch_array($r)){
           echo"<option value=' ". $supplier['id'] ." '>".$supplier['supplier_name']."</option>"; 
         }
        
        ?>
        </select>   
        </div>
        <div>
            <label for="editDescription"><br><b>Description</b></label>
            <textarea id="editDescription" name="editdescription" ></textarea>
        </div>
        <div >
           <label for="editImage"><br><b>Product Image</b></label>
           <input type="file" name="img" id="editImage"  accept="image/*">
        </div>
        <button type="button" id="editOkBtn" name="editOkBtn">OK</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
// Event listener for "Delete" links

$(document).on('click', '.deleteProduct', function (e) {
        e.preventDefault();

        var productId = $(this).data('productid');
        var pname = $(this).data('pname');

        if (confirm('Are you sure you want to delete ' + pname + '?')) {
           
            $.ajax({
                type: 'POST',
                data: { product_id: productId },
                url: 'delete-product.php',
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


////////////////////////////// Edit form javascript code //////////////////////////////////////


// Event listener for "Edit" links
$(document).on('click', '.editProduct', function (e) {
    e.preventDefault(); 
    var productId = $(this).data('productid');
    var productName = $(this).data('pname');
    var description = $(this).data('desc');
    var suppliers = $(this).data('suppliers').split(','); // Split the string of suppliers into an array if there were more than one supplier fo a specific product

    displayEditForm(productId, productName, description, suppliers);
    $('#editFormContainer').show(); // Show the edit form container
});

    // Event listener for closing the edit form
    $('#closeEditForm').click(function () {
        // Hide the edit form
        $('#editFormContainer').hide();
    });

// Event listener for "OK" button in edit form
$('#editOkBtn').click(function () {
    var productId = $('#editProductId').val();
    var productName = $('#editProductName').val();
    var description = $('#editDescription').val();
    var selectedSuppliers = $('#editSuppliersSelect').val();

     // Check if an image is selected
     var imageInput = $('#editImage')[0];
     var hasImage = imageInput.files.length > 0;

    // If no image is selected, display a message and prevent the form from being hidden
    if (!hasImage) {
        alert('You have to choose an image.');
        return;
    }
    
    // Prepare the form data for submission
    var formData = new FormData();
    formData.append('product_id', productId);
    formData.append('editproduct_name', productName);
    formData.append('editdescription', description);
    formData.append('suppliers', selectedSuppliers);
     // Append the image file
     formData.append('img', imageInput.files[0]);

    // Use AJAX to submit the form data
    $.ajax({
        type: 'POST',
        url: 'update-product.php',
        data: formData,
        processData: false,  // Important for sending FormData
        contentType: false,  // Important for sending FormData
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

function displayEditForm(productId, productName, description, suppliers) {
    $('#editProductId').val(productId);
    $('#editProductName').val(productName);
    $('#editDescription').val(description);

    // Set the selected options in the dropdown
    $('#editSuppliersSelect').val(suppliers);
}


</script>
</body>
</html> 