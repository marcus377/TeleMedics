<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Optional: Restrict role-specific access
if ($_SESSION['user_role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'telemedics_db';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$user_id = $_SESSION['user_id'];

// Fetch patient information from users table

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle update for phone and date_of_birth
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $phone = trim($_POST['phone'] ?? '');
    $dob = trim($_POST['date_of_birth'] ?? '');
    $update_stmt = $pdo->prepare("UPDATE users SET phone = ?, date_of_birth = ? WHERE id = ?");
    $update_stmt->execute([$phone, $dob, $user_id]);
    $info_updated = true;
    // Refresh patient info
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
} 

// Fetch upcoming appointments
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE patient_id = ? AND appointment_date >= CURDATE() ORDER BY appointment_date ASC LIMIT 5");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch medical records
$stmt = $pdo->prepare("SELECT * FROM medical_records WHERE patient_id = ? LIMIT 10");
$stmt->execute([$user_id]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - TeleMedics</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background-color: #007bff; color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .section { background-color: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .section h2 { color: #007bff; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f9f9f9; font-weight: bold; }
        .btn { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></h1>
            <p>Patient ID: <?php echo $patient['id']; ?></p>
            <form method="POST" action="logout.php" style="display:inline-block; margin-top:10px;">
                <button type="submit" class="btn" style="background-color:#e74c3c;">Logout</button>
            </form>
        </div>

        <div class="section">
            <h2>Patient Information</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo isset($patient['phone']) ? htmlspecialchars($patient['phone']) : '<span style="color:#e74c3c">Not set</span>'; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo isset($patient['date_of_birth']) ? htmlspecialchars($patient['date_of_birth']) : '<span style="color:#e74c3c">Not set</span>'; ?></p>
        </div>

        <div class="section">
            <h2>Upcoming Appointments</h2>
            <?php if (count($appointments) > 0): ?>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($appointments as $apt): ?>
                        <tr>
                            <td><?php echo $apt['appointment_date']; ?></td>
                            <td><?php echo $apt['appointment_time']; ?></td>
                            <td><?php echo htmlspecialchars($apt['doctor_name']); ?></td>
                            <td><a href="appointment_details.php?id=<?php echo $apt['id']; ?>" class="btn">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No upcoming appointments.</p>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>Medical Records</h2>
            <?php if (count($records) > 0): ?>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?php echo $record['created_date']; ?></td>
                            <td><?php echo htmlspecialchars($record['type']); ?></td>
                            <td><?php echo htmlspecialchars(substr($record['description'], 0, 50)); ?>...</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No medical records available.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>