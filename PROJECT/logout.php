<?php
session_start();

// Remove all session variables ( la 7ata terja3 t3abe mn l 0 lvalues l jded 7asab l user li n3amalo login )
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page
header('Location: login.php');
exit(); // Ensure that no code is executed after the redirect
?>
