<?php
session_start();
include 'includes/db.php';

$msg_success = "";
$msg_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
    if (mysqli_query($conn, $sql)) {
        $msg_success = "Your message has been sent successfully!";
    }
    else {
        $msg_error = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community | Event Western</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

 <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
            <i class="bi bi-geo-alt-fill text-primary me-2"></i>Event Western
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="events.php">Events</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="gallery.php">Gallery</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="community.php">Community</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold active" href="contact.php">Contact US</a></li>
                
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold text-warning" href="#"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION["username"]); ?></a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold text-danger" href="auth/logout.php">Logout</a></li>
                <?php
else: ?>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold text-info" href="auth/login.php">Login / Register</a></li>
                <?php
endif; ?>
                <li class="nav-item d-flex align-items-center ms-lg-3 mt-2 mt-lg-0">
                    <button class="btn btn-outline-light btn-sm" id="themeToggle" aria-label="Toggle Dark Mode">
                        <i class="bi bi-moon-stars-fill"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <header class="bg-dark text-white text-center py-5 border-top border-secondary" data-aos="fade-down">
        <div class="container py-2">
            <h1 class="display-5 fw-bold mb-2">Welcome to Event Western</h1>
            <p class="text-white-50">Have questions? We're here to help you connect with the Western Province.</p>
        </div>
    </header>

    <main class="container my-5 py-5">
        <div class="row mb-5">
            <div class="col-md-6" data-aos="fade-right">
                <p class="text-primary fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">Tagline</p>
                <h2 class="display-6 fw-bold mb-4">Contact us</h2>
                <p class="text-muted" style="max-width: 450px;">
                    Whether you are an event organizer looking to partner with us or an attendee with a question, our team is ready to assist you.
                </p>
            </div>

            <div class="col-md-6 mt-4 mt-md-0 d-flex flex-column gap-4" data-aos="fade-left">
                <div class="d-flex align-items-start gap-3">
                    <i class="bi bi-envelope fs-4 text-primary"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Email</h6>
                        <p class="mb-0 text-muted">info@eventwestern.lk</p>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3">
                    <i class="bi bi-telephone fs-4 text-primary"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Phone</h6>
                        <p class="mb-0 text-muted">+94 11 234 5678</p>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3">
                    <i class="bi bi-geo-alt fs-4 text-primary"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Office</h6>
                        <p class="mb-0 text-muted">123 Sample St, Colombo 03, Sri Lanka</p>
                    </div>
                </div>
            </div>
        </div>
<?php if (!empty($msg_success)): ?>
    <div class="alert alert-success"><?php echo $msg_success; ?></div>
<?php
endif; ?>
<?php if (!empty($msg_error)): ?>
    <div class="alert alert-danger"><?php echo $msg_error; ?></div>
<?php
endif; ?>
<form id="contactForm" class="p-4 shadow-sm border rounded" data-aos="fade-up" method="POST" action="">
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Message</label>
        <textarea name="message" class="form-control" rows="4" required></textarea>
    </div>
    <button type="submit" name="contact_submit" class="btn btn-primary w-100">Send Message</button>
</form>
        <div class="row">
            <div class="col-12">
                <div class="bg-light rounded shadow-sm overflow-hidden" style="min-height: 450px;" data-aos="zoom-in" data-aos-delay="200">
                    <iframe 
    id="contactMap"
    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d507000.0!2d80.0!3d6.84!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2slk!4v1711111111111" 
    width="100%" 
    height="450" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy">
</iframe>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-md-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Event Western</h5>
                    <p class="small">Connecting the community through shared experiences across the Western Province.</p>
                </div>
                <div class="col-md-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Quick Links</h5>
                    <p class="mb-1"><a href="index.php" class="text-white-50 text-decoration-none small">Home</a></p>
                    <p class="mb-1"><a href="events.php" class="text-white-50 text-decoration-none small">Events</a></p>
                    <p class="mb-1"><a href="community.php" class="text-white-50 text-decoration-none small">Community</a></p>
                </div>
                <div class="col-md-4 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Contact</h5>
                    <p class="small mb-1"><i class="bi bi-house-door me-2"></i> RUSL, Mihintale</p>
                    <p class="small mb-1"><i class="bi bi-envelope me-2"></i> info@eventwestern.lk</p>
                    <p class="small mb-1"><i class="bi bi-telephone me-2"></i> +94 11 234 5678</p>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center">
                <p class="small mb-0">© 2026 Copyright: <strong>Event_Western</strong></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/script.js"></script>
</body>
</html>