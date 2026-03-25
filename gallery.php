<?php
session_start();
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | Event Western</title>
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
                <li class="nav-item"><a class="nav-link px-3 fw-bold active" href="gallery.php">Gallery</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="community.php">Community</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="contact.php">Contact US</a></li>
                
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

<main class="container my-5">
    <div class="text-center mb-5" data-aos="fade-down" style="position: relative; z-index: 10;">
        <h1 class="fw-bold mb-3">Event Gallery</h1>
        <p class="text-muted mb-4">Click an event category to view captured moments.</p>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="input-group input-group-lg shadow-sm">
    <span class="input-group-text bg-white border-end-0">
        <i class="bi bi-search text-muted"></i>
    </span>
    <input type="text" id="gallerySearch" class="form-control border-start-0" placeholder="Search event categories...">
    
    <button class="btn btn-outline-secondary dropdown-toggle px-4 fw-bold" type="button" data-bs-toggle="dropdown" id="dropdownBtn">
        Category
    </button>
    
    <ul class="dropdown-menu dropdown-menu-end shadow">
        <li><a class="dropdown-item active" href="#">All Events</a></li>
        <li><a class="dropdown-item" href="#">Musical</a></li>
        <li><a class="dropdown-item" href="#">Sports</a></li>
        <li><a class="dropdown-item" href="#">Exhibition</a></li>
        <li><a class="dropdown-item" href="#">Big Match</a></li>
    </ul>

    <button class="btn btn-primary px-4 fw-bold" type="button" id="gallerySearchBtn">Search</button>
</div>
            </div>
        </div>
    </div>

    <div class="row g-4" id="galleryContainer">
        <?php
$dynamic_collections = [];
$query = "SELECT * FROM events ORDER BY event_date DESC";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $delay = 100;
    while ($row = mysqli_fetch_assoc($result)) {
        $eventId = "event_" . $row['id'];

        $dynamic_collections[$eventId] = [
            $row['image_url']
        ];
?>
                <div class="col-lg-4 col-md-6 gallery-item" data-category="<?php echo htmlspecialchars($row['category']); ?>" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                    <div class="card border-0 shadow-sm h-100" style="cursor: pointer;" onclick="openEventGallery('<?php echo $eventId; ?>', '<?php echo addslashes(htmlspecialchars($row['title'])); ?>')">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center">
                            <p class="fw-bold mb-1"><?php echo htmlspecialchars($row['title']); ?></p>
                            <span class="badge bg-primary rounded-pill" id="badge-<?php echo $eventId; ?>">View <?php echo count($dynamic_collections[$eventId]); ?> Photos</span>
                        </div>
                    </div>
                </div>
                <?php
        $delay += 100;
        if ($delay > 300)
            $delay = 100;
    }
}
else {
    echo "<div class='col-12 text-center'><p class='text-muted fs-5'>No gallery photos available yet.</p></div>";
}
?>
    </div>
</main>

<div class="modal fade" id="photoGalleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" id="galleryTitle">Event Highlights</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light" style="max-height: 80vh; overflow-y: auto;">
                <div class="row g-3" id="photoGrid">
                    </div>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container text-center text-md-left">
        <div class="row text-center text-md-left">
            
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Event Western</h5>
                <p>Your one-stop platform to discover and register for the best events in the Western Province of Sri Lanka.</p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Quick Links</h5>
                <p><a href="index.php" class="text-white" style="text-decoration: none;">Home</a></p>
                <p><a href="events.php" class="text-white" style="text-decoration: none;">Events</a></p>
                <p><a href="community.php" class="text-white" style="text-decoration: none;">Community</a></p>
            </div>

            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3 text-center text-md-start">
                <h5 class="text-uppercase mb-4 font-weight-bold text-primary">Contact</h5>
                <p><i class="bi bi-house-door-fill me-2"></i> RUSL, Mihintale</p>
                <p><i class="bi bi-envelope-fill me-2"></i> info@eventwestern.lk</p>
                <p><i class="bi bi-telephone-fill me-2"></i> +94 11 234 5678</p>
            </div>

        </div>

        <hr class="mb-4">

        <div class="row align-items-center">
            <div class="col-md-7 col-lg-8">
                <p>© 2026 Copyright: <strong>Event_Western</strong></p>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="text-center text-md-right">
                    <ul class="list-unstyled list-inline">
                        <li class="list-inline-item"><a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="bi bi-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="bi bi-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="bi bi-twitter"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer><script>
    window.dynamicEventCollections = <?php echo json_encode($dynamic_collections ?? []); ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="js/script.js"></script>
</body>
</html>