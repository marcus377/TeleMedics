<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
header("Location: login.php");
exit();
}

$result = $conn->query("
SELECT appointments.*, 
p.first_name AS patient,
d.first_name AS doctor
FROM appointments
JOIN users p ON appointments.patient_id=p.id
JOIN users d ON appointments.doctor_id=d.id
ORDER BY appointment_date DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Appointments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h3>All Appointments</h3>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Patient</th>
<th>Doctor</th>
<th>Date</th>
<th>Status</th>
</tr>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['patient']; ?></td>

<td><?php echo $row['doctor']; ?></td>

<td><?php echo $row['appointment_date']; ?></td>

<td><?php echo $row['status']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>