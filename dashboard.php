<?php
session_start();
include 'includes/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}
include_once 'includes/functions.php';
$msg_success = "";
$msg_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_event'])) {
    $title = mysqli_real_escape_string($conn, sanitize_input($_POST['title']));
    $description = mysqli_real_escape_string($conn, sanitize_input($_POST['description']));
    $image_url = mysqli_real_escape_string($conn, sanitize_input($_POST['image_url']));
    $location_name = mysqli_real_escape_string($conn, sanitize_input($_POST['location_name']));
    $district = mysqli_real_escape_string($conn, sanitize_input($_POST['district']));
    $category = mysqli_real_escape_string($conn, sanitize_input($_POST['category']));
    $event_date = mysqli_real_escape_string($conn, sanitize_input($_POST['event_date']));

    $sql = "INSERT INTO events (title, description, image_url, location_name, district, category, event_date) VALUES ('$title', '$description', '$image_url', '$location_name', '$district', '$category', '$event_date')";

    if (mysqli_query($conn, $sql)) {
        $msg_success = "Success! The new event has been added directly to the Events page.";
    }
    else {
        $msg_error = "Error adding event: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Event Western</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
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
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="contact.php">Contact US</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold active bg-primary text-white rounded" href="dashboard.php">Dashboard</a></li>
                <?php if (isset($_SESSION["user_id"])): ?>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold text-warning" href="#"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION["username"]); ?></a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold text-danger" href="auth/logout.php">Logout</a></li>
                <?php
else: ?>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold text-info" href="auth/login.php">Login / Register</a></li>
                <?php
endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow rounded-4 p-4">
                <h3 class="fw-bold mb-4">User Dashboard - Host an Event</h3>
                <?php if (!empty($msg_success)): ?>
                    <div class="alert alert-success fw-bold"><i class="bi bi-check-circle-fill me-2"></i><?php echo $msg_success; ?> <a href="events.php" class="alert-link">View Events</a></div>
                <?php
endif; ?>
                <?php if (!empty($msg_error)): ?>
                    <div class="alert alert-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $msg_error; ?></div>
                <?php
endif; ?>
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Event Title</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. Colombo Food Fest">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Event Date</label>
                            <input type="date" name="event_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">District</label>
                            <select name="district" class="form-select" required>
                                <option value="Colombo">Colombo</option>
                                <option value="Gampaha">Gampaha</option>
                                <option value="Kalutara">Kalutara</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="Musical">Musical</option>
                                <option value="Sports">Sports</option>
                                <option value="Exhibition">Exhibition</option>
                                <option value="Drama">Drama</option>
                                <option value="Big Match">Big Match</option>
                                <option value="Cultural">Cultural</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Specific Location (Venue)</label>
                            <input type="text" name="location_name" class="form-control" required placeholder="e.g. Viharamahadevi Park">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Image URL</label>
                            <input type="text" name="image_url" class="form-control" placeholder="images/..." value="images/musical/aloka.jpg">
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-bold">Event Description</label>
                            <textarea name="description" class="form-control" rows="4" required placeholder="Tell people what to expect..."></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="submit_event" class="btn btn-primary btn-lg w-100 fw-bold">Publish Event to Public Feed</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
