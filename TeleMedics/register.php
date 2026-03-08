<?php
require_once "config.php";

$errors = [];
$success = false;

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = "Invalid request. Please try again.";
    } else {
        $fullname = trim($_POST['fullname'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $role = 'patient'; // Default role for new registrations

        // Split fullname into first and last name
        $name_parts = explode(' ', $fullname, 2);
        $first_name = $name_parts[0] ?? '';
        $last_name = $name_parts[1] ?? '';

    // Validation
    if (empty($fullname)) {
        $errors[] = "Full name is required.";
    } elseif (count($name_parts) < 2) {
        $errors[] = "Please enter both first and last name.";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If no errors, process registration
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // Check if email exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        if (!$check) {
            $errors[] = "Database error. Please try again.";
        } else {
            $check->bind_param("s", $email);
            if (!$check->execute()) {
                $errors[] = "Database error. Please try again.";
            } else {
                $check->store_result();
                
                if ($check->num_rows > 0) {
                    $errors[] = "Email already registered.";
                } else {
                    // Insert new user with proper field names
                    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
                    if (!$stmt) {
                        $errors[] = "Database error. Please try again.";
                    } else {
                        $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $role);
                        
                        if ($stmt->execute()) {
                            $success = true;
                        } else {
                            $errors[] = "Registration failed. Please try again.";
                        }
                        $stmt->close();
                    }
                }
                $check->close();
            }
        }
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - TeleMedics</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 3px; }
        button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .error { color: #d32f2f; margin-bottom: 10px; }
        .success { color: #388e3c; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        
        <?php foreach ($errors as $error): ?>
            <div class="error">✗ <?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
        
        <?php if ($success): ?>
            <div class="success">✓ Registration successful! <a href="login.php">Login here</a></div>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="fullname" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password:</label>
                    <input type="password" name="confirm_password" required>
                </div>
                <button type="submit">Register</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>