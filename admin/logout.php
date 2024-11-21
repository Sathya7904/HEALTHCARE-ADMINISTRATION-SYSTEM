<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    if ($username === 'admin') {
        session_unset();
        session_destroy();
        header("Location: admin_login.php");
        exit();
    } 
}
header("Location: admin_login.php");
exit();
?>
