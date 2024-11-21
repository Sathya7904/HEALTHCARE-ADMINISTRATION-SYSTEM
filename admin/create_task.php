<?php
include('db_create_connection.php'); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_title = $_POST['title'];
    $task_description = $_POST['description'];
    $assigned_to = $_POST['assigned_to']; 
    $due_date = $_POST['due_date'];
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, assigned_to, due_date, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("ssss", $task_title, $task_description, $assigned_to, $due_date);
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?success=task_created");
        exit();
    } else {
        header("Location: create_task.php?error=task_creation_failed");
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="./create_task.css">
</head>
<body>
    <div class="dashboard-container">
        <aside>
            <h2>Admin Portal</h2>
            <ul>
                <li><a href="admin_dashboard.php">Home</a></li>
                <li><a href="./create_task.php">Create Task</a></li>
                <li><a href="./patient_history.php">Patient History</a></li>
                <li><a href="alternate_task.php">Alternate Task</a></li>
                <li><a href="./leave_approve.php">Leave Approval</a></li>
                <li><a href="./view_task.php">View Task</a></li>
                <li><a href="./alternate_viewtask.php">View Alternate Task</a></li>
                <li><a href="./logout.php">Log out</a></li>
            </ul>
        </aside>
        <main>
            <div class="main-content-wrapper">
                <div class="greeting">
                    <h2>Hello! Admin <span>👋</span></h2>
                </div>
                <div class="admin-profile">
                    <h3>ADMIN</h3>
                    <p>ADM001</p>
                </div>
                <div class="create-task-container">
                    <h1>Create New Task</h1>
                    <?php if (isset($_GET['success'])): ?>
                        <p style="color: green;">Task created successfully!</p>
                    <?php elseif (isset($_GET['error'])): ?>
                        <p style="color: red;">Failed to create the task. Please try again.</p>
                    <?php endif; ?>
                    <form action="create_task.php" method="POST">
                        <label for="title">Task Title</label>
                        <input type="text" id="title" name="title" required>
                        <label for="description">Description</label>
                        <textarea id="description" name="description" required></textarea>
                        <label for="assigned_to">Assign To (Nurse ID)</label>
                        <input type="text" id="assigned_to" name="assigned_to" placeholder="Enter nurse ID (e.g., NUR001)" required>
                        <label for="due_date">Due Date</label>
                        <input type="date" id="due_date" name="due_date" required>
                        <button type="submit">Create Task</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
