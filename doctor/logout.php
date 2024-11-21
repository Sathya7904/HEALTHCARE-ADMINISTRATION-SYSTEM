<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    if ($username === 'doctor') {
        session_unset();
        session_destroy();
        header("Location: doctor_login.php");
        exit();
    } 
}
header("Location: doctor_login.php");
exit();
?>
