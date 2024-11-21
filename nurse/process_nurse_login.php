<?php
session_start();
include 'db_connection.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']); 
    $stmt = $conn->prepare("SELECT nurse_id, name FROM nurses WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['nurse_id'] = $row['nurse_id']; 
        $_SESSION['username'] = $username;        
        header("Location: nurse_dashboard.php");
        exit;
    } else {
        echo "Invalid username or password!";
    }
    $stmt->close();
}
?>
