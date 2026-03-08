<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Optional: Restrict role-specific access
if ($_SESSION['user_role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "telemedics_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch doctor info
$sql = "SELECT * FROM doctors WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$doctor = $stmt->get_result()->fetch_assoc();

// Fetch appointments
$sql = "SELECT * FROM appointments WHERE doctor_id = ? ORDER BY appointment_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$appointments = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { background-color: #007bff; color: white; padding: 15px; }
        .appointments { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    .logout {
        background-color: #e74c3c;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
    }
    </style>
</head>
<body>
    <div class="header" style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h1>Welcome, Dr. <?php echo htmlspecialchars($doctor['name']); ?></h1>
        </div>
        <form method="POST" action="logout.php">
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>
    
    <div class="appointments">
        <h2>Upcoming Appointments</h2>
        <table>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $appointments->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                <td><?php echo $row['appointment_date']; ?></td>
                <td><?php echo $row['appointment_time']; ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>