<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_track";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $leave_id = $_POST['id'];
    $status = $_POST['status']; 
    $stmt = $conn->prepare("UPDATE leave_requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $leave_id);
    if ($stmt->execute()) {
        echo "Leave request updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
