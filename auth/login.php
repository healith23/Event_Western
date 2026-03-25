<?php
session_start();
include '../includes/db.php';
include_once '../includes/functions.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, sanitize_input($_POST['email']));
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        redirect("../index.php");
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Event Western</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <a href="../index.php" class="text-decoration-none h3 fw-bold text-dark d-flex align-items-center justify-content-center mb-3">
                                <i class="bi bi-geo-alt-fill text-primary me-2"></i>Event Western
                            </a>
                            <h4 class="fw-bold">Welcome Back</h4>
                            <p class="text-muted">Enter your credentials to login</p>
                        </div>

                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email address</label>
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="name@example.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">Login</button>
                        </form>

                        <div class="text-center mt-4 text-muted">
                            Don't have an account? <a href="register.php" class="text-primary text-decoration-none fw-semibold">Sign up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>