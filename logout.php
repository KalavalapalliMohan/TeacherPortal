<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php"); // Redirect to home or login page after logout
exit();
?>
