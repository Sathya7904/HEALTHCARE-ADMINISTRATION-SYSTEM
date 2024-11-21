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
if (!isset($_SESSION['nurse_id'])) {
    header("Location: index.php"); 
    exit;
}
$records_per_page = 8; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $records_per_page; 
$sql = "SELECT nurse_id, patient_name, note, created_at FROM patient_notes ORDER BY created_at DESC LIMIT $offset, $records_per_page";
$result = $conn->query($sql);
$total_pages = 0;
if ($result) {
    $total_records_sql = "SELECT COUNT(*) AS total FROM patient_notes";
    $total_records_result = $conn->query($total_records_sql);
    
    if ($total_records_result) {
        $total_records = $total_records_result->fetch_assoc()['total'];
        $total_pages = ceil($total_records / $records_per_page);
    } else {
        echo "Error retrieving total records: " . $conn->error;
    }
} else {
    echo "Error retrieving patient notes: " . $conn->error;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient History</title>
    <link rel="stylesheet" href="patient_history.css">
</head>
<body>
    <div class="dashboard-container">
        <aside>
            <h2>Nurse Portal</h2>
            <ul>
                <li><a href="nurse_dashboard.php">Home</a></li>
                <li><a href="view_task.php">View Tasks</a></li>
                <li><a href="leave_apply.php">Leave Apply</a></li>
                <li><a href="patient_notes.php">Patient Notes</a></li>
                <li><a href="patient_history.php">Patient History</a></li>
                <li><a href="leave_summary.php">Leave Summary</a></li>
                <li><a href="alternate_viewtask.php">Alternate View Task</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </aside>
        
        <main>
            <div class="main-content-wrapper">
                <h1>Patient History</h1>
                
                <!-- Table to Display Patient Notes -->
                <table>
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Note</th>
                            <th>Nurse ID</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['note']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nurse_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4">No patient notes available.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="prev">Previous</a>
                    <?php else: ?>
                        <span class="disabled">Previous</span>
                    <?php endif; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="next">Next</a>
                    <?php else: ?>
                        <span class="disabled">Next</span>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
