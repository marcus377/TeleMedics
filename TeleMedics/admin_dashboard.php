<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
header("Location: login.php");
exit();
}

// Count users
$patients = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='patient'")->fetch_assoc()['total'];

$doctors = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='doctor'")->fetch_assoc()['total'];

$admins = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='admin'")->fetch_assoc()['total'];

$appointments = $conn->query("SELECT COUNT(*) AS total FROM appointments")->fetch_assoc()['total'];

// Latest appointments
$recent = $conn->query("
SELECT appointments.*, 
p.first_name AS patient_name,
d.first_name AS doctor_name
FROM appointments
JOIN users p ON appointments.patient_id=p.id
JOIN users d ON appointments.doctor_id=d.id
ORDER BY appointment_date DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f5f7fb;
}

.card{
border:none;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.navbar{
background:#003366;
}

.navbar-brand{
color:white;
font-weight:bold;
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg">
<div class="container">

<span class="navbar-brand">TeleMedics Admin Panel</span>

<div>
<a href="manage_users.php" class="btn btn-light btn-sm">Manage Users</a>

<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

</div>
</nav>

<div class="container mt-5">

<h3 class="mb-4">System Overview</h3>

<div class="row">

<div class="col-md-3">
<div class="card text-center p-3">
<h4><?php echo $patients; ?></h4>
<p>Total Patients</p>
</div>
</div>

<div class="col-md-3">
<div class="card text-center p-3">
<h4><?php echo $doctors; ?></h4>
<p>Total Doctors</p>
</div>
</div>

<div class="col-md-3">
<div class="card text-center p-3">
<h4><?php echo $admins; ?></h4>
<p>Admins</p>
</div>
</div>

<div class="col-md-3">
<div class="card text-center p-3">
<h4><?php echo $appointments; ?></h4>
<p>Total Appointments</p>
</div>
</div>

</div>

<hr class="my-5">

<h4>Recent Appointments</h4>

<table class="table table-bordered mt-3">

<tr>
<th>Patient</th>
<th>Doctor</th>
<th>Date</th>
<th>Status</th>
</tr>

<?php while($row=$recent->fetch_assoc()){ ?>

<tr>

<td><?php echo htmlspecialchars($row['patient_name']); ?></td>

<td><?php echo htmlspecialchars($row['doctor_name']); ?></td>

<td><?php echo $row['appointment_date']; ?></td>

<td><?php echo $row['status']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>