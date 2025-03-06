<?php
session_start();
session_destroy();  // Destroy all session data (log out)
header("Location: admin-login.php");  // Redirect to login page after logout
exit;
?>
