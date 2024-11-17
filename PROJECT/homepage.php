<!DOCTYPE html>
<html lang="en">
<head>
    <title>IMS Login - Inventory Management System</title>
    <link rel="stylesheet" type="text/css" href="./CSS/login.css">
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
    <!-- we use the fontawesamoe for icons-->
</head>
<body>
    <div class="header">
        <div class="homepageContainer">
            <div class="fixed-login-container">
                <a href="login.php">Login</a>
            </div>
        </div>
    </div>
    <div class="banner">
        <div class="homepageContainer">
            <div class="bannerHeader">
                <div class="ims-container">
                    <h1>IMS</h1>
                </div>
                <div class="subtitle-container">
                    <p class="subtitle">Inventory Management System</p>
                    <hr>
                    <br>
                    <p class="description">Track your goods throughout your entire supply chain, from purchasing to production to end sales</p>
                    <br>
                </div>
            </div>
            <div class="bannerIcons">
                <a href="#"><i class="fa fa-apple"></i></a>
                <a href="#"><i class="fa fa-android"></i></a>
                <a href="#"><i class="fa fa-windows"></i></a>
            </div>
            <div class="homepageFeatures">
                <div class="homepageFeature">
                    <span class="featureIcon"><i class="fa fa-gear"></i></span>
                    <h3 class="featureTitle">Editable Theme</h3>
                    <p class="featureDescription">Customize the look and feel of your website with an easily editable theme. No coding required!</p>
                </div>
                <div class="homepageFeature">
                    <span class="featureIcon"><i class="fa fa-star"></i></span>
                    <h3 class="featureTitle">Flat Design</h3>
                    <p class="featureDescription">Enjoy a modern and sleek flat design that enhances the user experience and keeps everything simple.</p>
                </div>
                <div class="homepageFeature">
                    <span class="featureIcon"><i class="fa fa-globe"></i></span>
                    <h3 class="featureTitle">Reach Your Audience</h3>
                    <p class="featureDescription">Expand your reach and connect with your audience globally. Manage your inventory with ease.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="homepageNotified">
        <div class="homepageContainer">
            <div class="homepageNotifiedContainer">
                <div class="emailForm">
                    <h3 style="color: palevioletred;">Get Notified Of Any Updates!</h3>
                    <hr>
                    <p>Stay informed about the latest updates. Sign up to receive notifications and important announcements about our inventory management system.</p>
                    <form action="">
                        <div class="formContainer">
                            <input type="text" placeholder="Email Address">
                            <button>Notify</button>
                        </div>
                    </form>
                </div>
                <div class="video">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/MhfTBZhpBcI?si=2DzB9HSDQmGtesgu" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="socials">
        <div class="homepageContainer">
            <h3 class="socialHeader">Say Hi & Get in Touch</h3>
            <p class="socialText">Connect with us on social media. We'd love to hear from you!</p>
            <div class="socialIconsContainer">
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
                <a href="#"><i class="fa fa-google-plus"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="homepageContainer">
            <a href="#">Contact</a>
            <a href="#">Download</a>
            <a href="#">Press</a>
            <a href="#">Email</a>
            <a href="#">Support</a>
            <a href="#">Privacy Policy</a>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var loginContainer = document.querySelector(".fixed-login-container");

            window.addEventListener("scroll", function () {
                var scrolled = window.scrollY > 0;
                loginContainer.classList.toggle("scrolled", scrolled);
            });
        });
    </script>
</body>
</html>

