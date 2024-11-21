<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('db_view_connection.php');
if (!isset($_SESSION['nurse_id'])) {
    header("Location: admin_login.php?error=not_logged_in");
    exit;
}
$nurse_id = $_SESSION['nurse_id'];
$stmt = $conn->prepare("SELECT title, description, due_date, status FROM tasks WHERE assigned_to = ?");
$stmt->bind_param("s", $nurse_id);
$stmt->execute();
$result = $stmt->get_result();
$_SESSION['tasks'] = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>
