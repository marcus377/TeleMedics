<?php
// patient_appointments.php

session_start();
require_once 'db_connection.php'; // Assumes a file for DB connection

// Check if user is logged in
if (!isset($_SESSION['patient_id'])) {
    header('Location: login.php');
    exit();
}

$patient_id = $_SESSION['patient_id'];

// Fetch appointments for the patient
$stmt = $conn->prepare("SELECT a.id, a.date, a.time, d.name AS doctor_name, a.status 
                        FROM appointments a 
                        JOIN doctors d ON a.doctor_id = d.id 
                        WHERE a.patient_id = ? 
                        ORDER BY a.date DESC, a.time DESC");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>My Appointments</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Doctor</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['date']); ?></td>
            <td><?php echo htmlspecialchars($row['time']); ?></td>
            <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="book_appointment.php">Book New Appointment</a>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>