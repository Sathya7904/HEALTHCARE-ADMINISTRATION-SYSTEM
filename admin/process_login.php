<?php
include('db_admin_connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = hash('sha256', $password);
    echo "Computed Hash: " . $hashed_password . "<br>";
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        header("Location: admin_login.php?error=invalid_credentials");
        exit();
    }
}
?>
