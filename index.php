<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/src/' . $class_name . '.php';
});
$db = new Database();
session_start();
$successMessage = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanoi Marathon</title>
    <!-- Bootstrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Hero Section Style */
        .hero-section {
            position: relative;
            background-image: 
                linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%), /* Gradient from transparent to dark */
                url('https://res.cloudinary.com/peloton-cycle/image/fetch/f_auto,c_limit,w_3840,q_90/https://images.ctfassets.net/6ilvqec50fal/FbOXaCWxwuI975XgxlDms/1d9bc48af213a35b62fa2dc8a1dbb362/Running_Marathon.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            height: 100vh; /* Ensure the hero section fills the screen height */
            padding: 0; /* Remove padding */
        }

        .hero-content {
            position: absolute;
            bottom: 100px; /* Adjust the distance from the bottom */
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }

        .hero-content h2 {
            font-size: 4rem; /* Increase font size for the title */
            font-weight: bold; /* Make title bold */
            margin-bottom: 20px; /* Add some space below the title */
        }

        .hero-content p {
            font-size: 1.75rem; /* Increase font size for the description */
            margin-bottom: 30px; /* Add space below the paragraph */
        }

        .hero-content .btn {
            font-size: 1.5rem; /* Increase font size for buttons */
            padding: 15px 30px; /* Increase padding for larger buttons */
            margin: 10px; /* Add spacing between buttons */
        }

        .modal.fade .modal-dialog {
            max-width: 90%; /* Adjust modal size for better view */
        }

        .modal-body img.enlarge-image {
            transform: scale(1.1); /* Enlarge image slightly */
        }
    </style>
</head>
<body>

    <?php include 'template/navbar.html'; ?>
    <?php include 'template/message.php'; ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h2>Welcome to Hanoi Marathon</h2>
            <p>Challenge yourself and conquer the marathon course.</p>
            <?php if (!isset($_SESSION['user'])): ?>
            <a href="register.php" class="btn btn-outline-light btn-lg">Register Now</a>
            <a href="login.php" class="btn btn-outline-light btn-lg">Login</a>
            <?php else: ?>
            <a href="raceregister.php" class="btn btn-outline-light btn-lg">Register race</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Marathon Events -->
    <section class="container py-5">
    <!-- Marathon Title -->
    <h2 class="text-center mb-4">Marathon Hanoi 2024</h2>

    <!-- Grid of images -->
    <div class="row g-4">
        <!-- Each marathon image with description -->
        <div class="col-md-4 col-sm-6">
            <a href="#" class="image-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" data-bs-desc="The Spring Marathon takes place in April 2024, offering a scenic route through Hanoi.">
                <img src="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" class="img-fluid rounded" alt="Image 1">
            </a>
        </div>
        <div class="col-md-4 col-sm-6">
            <a href="#" class="image-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" data-bs-desc="The Summer Marathon will be in June 2024, with exciting challenges and fun activities for runners of all levels.">
                <img src="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" class="img-fluid rounded" alt="Image 2">
            </a>
        </div>
        <div class="col-md-4 col-sm-6">
            <a href="#" class="image-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" data-bs-desc="Race through the beautiful streets of Hanoi, showcasing the city’s rich culture and vibrant history.">
                <img src="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" class="img-fluid rounded" alt="Image 3">
            </a>
        </div>
        <div class="col-md-4 col-sm-6">
            <a href="#" class="image-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" data-bs-desc="Participants will enjoy an exciting marathon route with various exciting checkpoints and a vibrant crowd cheering them on.">
                <img src="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" class="img-fluid rounded" alt="Image 4">
            </a>
        </div>
        <div class="col-md-4 col-sm-6">
            <a href="#" class="image-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" data-bs-desc="Spectacular views along the race route make this marathon one of the most scenic in the region.">
                <img src="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" class="img-fluid rounded" alt="Image 5">
            </a>
        </div>
        <div class="col-md-4 col-sm-6">
            <a href="#" class="image-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" data-bs-desc="Join the excitement as marathoners pass through iconic landmarks in Hanoi, experiencing both urban and natural beauty.">
                <img src="https://cdn.hcmcmarathon.com/wp-content/uploads/42KM.png" class="img-fluid rounded" alt="Image 6">
            </a>
        </div>
    </div>

    <!-- Modal for displaying clicked image with description -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Modal Content (Image + Description) -->
                    <div class="row">
                        <!-- Image Column -->
                        <div class="col-md-6">
                            <img id="modalImage" src="" alt="Marathon Image" class="img-fluid rounded" style="transition: transform 0.3s ease;">
                        </div>
                        <!-- Description Column -->
                        <div class="col-md-6">
                            <p id="modalDescription" class="lead"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Register Button -->
        <div class="text-center mt-5">
        <a href="raceregister.php" class="btn btn-primary btn-lg">Register for Race</a>
    </div>
    </section>

<!-- Add JavaScript to handle image modal -->


<script>
    // jQuery to handle modal image and description dynamically
    const imageLinks = document.querySelectorAll('.image-link');
    imageLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            const imgSrc = this.getAttribute('data-bs-img');
            const desc = this.getAttribute('data-bs-desc');
            
            // Set modal image and description dynamically
            document.getElementById('modalImage').src = imgSrc;
            document.getElementById('modalDescription').textContent = desc;
        });
    });
</script>


    <!-- Bootstrap JS and Popper.js Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>