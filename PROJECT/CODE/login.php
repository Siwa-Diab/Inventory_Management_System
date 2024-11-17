<?php
session_start();

// Check if the user is already logged in ( ya3ne iza l id te3ul l user ma25ude ma bi3ud yredne 3al login page)
if (isset($_SESSION['id'])) {
    header('Location: dashboard.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "inventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = mysqli_query($conn, "SELECT id, first_name, last_name, email, password, status FROM users WHERE email='$email'");

        if ($data = mysqli_fetch_array($stmt)) {
            if ($data['email'] == $email && $data['password'] == $password){
                if ($data['status'] < 3) {
                    // Now I want to set the status to 0 because the login was successful
                    mysqli_query($conn, "UPDATE users SET status = 0 WHERE email= '$email'");
                    // Set session variables
                    $_SESSION['id'] = $data['id'];  // hayde li 3am shayik 3layha bikl marra ba3mel login iza mawjude aw la2 already
                    $_SESSION['first_name'] = $data['first_name'];
                    $_SESSION['last_name'] = $data['last_name'];
                    $_SESSION['password'] = $data['password'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['created_at'] = $data['created_at'];
                    $_SESSION['updated_at'] = $data['updated_at'];
                    $_SESSION['status'] = $data['status'];

                    $first_name=$_SESSION['first_name'];

                     // Debug output
                  echo '<br>Session variables set: ' . print_r($_SESSION, true);
                     header('Location:dashboard.php');
                   
                } else {
                    $errorMessage = "This account is blocked, sorry :( <br> Try using another account";
                }
            } else {
                $errorMessage = "Wrong email or password, please try again!";
                $s = $data["status"] + 1;
                mysqli_query($conn, "UPDATE users SET status = $s WHERE email = '$email'");

                if ($data['status'] == 3) {
                    $errorMessage = "The maximum number of tries is reached, and now your account is blocked :(";
                }
            }
        }else{
            $errorMessage="These email and password aren't present in the system.";
        }
    } else {
        $errorMessage = "You have to fill both the email and password !";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS Login - Inventory Management System</title>
    <link rel="stylesheet" type="text/css" href="./CSS/login.css">
   
</head>
<body id="loginBody">
    <div class="container"> 
        <div class="loginHeader">
            <div class="logoContainer">
                <h2>Inventory Management System</h2>
            </div>   
        </div>

        <div class="loginBody">
            <form action="login.php" method="post">
                <div class="loginInputsContainer">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" />
                </div>
                <div class="loginInputsContainer">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Password" />
                </div>
                <div class="loginButtonContainer">
                    <button type="submit" name="login">Login</button>
                </div>  
            </form>

            <?php
            // Check if there is an error message
            if (isset($errorMessage)) {
                echo '<div class="errorContainer">' . $errorMessage . '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
