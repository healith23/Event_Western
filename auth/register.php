<?php
session_start();
include '../includes/db.php';
include_once '../includes/functions.php';
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, sanitize_input($_POST['username']));
    $email = mysqli_real_escape_string($conn, sanitize_input($_POST['email']));
    
    // Check if email exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already registered.";
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Registration successful! You can now <a href='login.php' class='alert-link'>login</a>.";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Event Western</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <a href="../index.php" class="text-decoration-none h3 fw-bold text-dark d-flex align-items-center justify-content-center mb-3">
                                <i class="bi bi-geo-alt-fill text-primary me-2"></i>Event Western
                            </a>
                            <h4 class="fw-bold">Create an Account</h4>
                            <p class="text-muted">Join us to register for events</p>
                        </div>

                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <?php if(!empty($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php else: ?>

                        <form method="POST" action="" onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="JohnDoe" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email address</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="name@example.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="••••••••" required>
                                <div class="form-text" id="passwordError">Must be at least 6 characters long.</div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">Sign Up</button>
                        </form>
                        
                        <?php endif; ?>

                        <div class="text-center mt-4 text-muted">
                            Already have an account? <a href="login.php" class="text-primary text-decoration-none fw-semibold">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function validateForm() {
            const pwd = document.getElementById('password').value;
            if(pwd.length < 6) {
                document.getElementById('passwordError').classList.add('text-danger');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>