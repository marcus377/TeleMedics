<?php
session_start();
require_once "config.php";

// Allow only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Handle delete user
if (isset($_GET['delete'])) {

$id = intval($_GET['delete']);

$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manage_users.php");
exit();
}

// Fetch all users
$result = $conn->query("SELECT id, first_name, email, role FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Manage Users</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2 class="text-center mb-4">System Users</h2>

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo htmlspecialchars($row['id']); ?></td>

<td><?php echo htmlspecialchars($row['first_name']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo htmlspecialchars($row['role']); ?></td>

<td>

<a href="?delete=<?php echo $row['id']; ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this user?');">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>

<?php
$conn->close();
?>