<?php
// doctor_appointments.php

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'telemedics';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch doctor appointments
$sql = "SELECT a.id, a.patient_name, a.appointment_date, a.status, d.name AS doctor_name
        FROM appointments a
        JOIN doctors d ON a.doctor_id = d.id
        ORDER BY a.appointment_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Appointments</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Doctor Appointments</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Patient Name</th>
            <th>Doctor Name</th>
            <th>Appointment Date</th>
            <th>Status</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">No appointments found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>