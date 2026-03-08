<?php
require_once "config.php";

$error = "";

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if(isset($_POST['login'])){

// Verify CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {

$error = "Invalid request. Please try again.";

} else {

$email = strtolower(trim($_POST['email']));
$password = trim($_POST['password']);

// Validate input
if (empty($email) || empty($password)) {

$error = "Email and password are required";

} else {

$sql = "SELECT * FROM users WHERE email=? LIMIT 1";

$stmt = $conn->prepare($sql);

if(!$stmt){

$error = "Database error. Please try again.";

}else{

$stmt->bind_param("s",$email);

if(!$stmt->execute()){

$error = "Database error. Please try again.";

}else{

$result = $stmt->get_result();

if($result->num_rows == 1){

$user = $result->fetch_assoc();

if(password_verify($password,$user['password'])){

// Security headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");

// Create session
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['first_name'];
$_SESSION['user_role'] = $user['role'];

if($user['role']=="patient"){

header("Location: patient_dashboard.php");
exit();

}elseif($user['role']=="doctor"){

header("Location: doctor_dashboard.php");
exit();

}elseif($user['role']=="admin"){

header("Location: admin_dashboard.php");
exit();

}

}else{

$error = "Invalid password";

}

}else{

$error = "Invalid email or password";

}

}

$stmt->close();

}

}

}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>TeleMedics Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background: linear-gradient(135deg,#0055cc,#00b4b4);
height:100vh;
display:flex;
align-items:center;
justify-content:center;
font-family:Arial;
}

.login-card{
background:white;
padding:40px;
border-radius:10px;
width:400px;
box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

</style>

</head>

<body>

<div class="login-card">

<h3 class="text-center mb-4">TeleMedics Login</h3>

<?php if($error!=""){ ?>

<div class="alert alert-danger">
<?php echo $error; ?>
</div>

<?php } ?>

<form method="POST">

<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" name="login" class="btn btn-primary w-100">
Login
</button>

</form>

<div class="text-center mt-3">
<a href="register.php">Create an Account</a>
</div>

</div>

</body>
</html>