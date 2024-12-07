<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/src/' . $class_name . '.php';
});
$db = new Database();
$user = new User();
$race = new Race();
session_start();
// $_SESSION = [];
$list_races = $race->getRaces();
$successMessage = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
$errorMessage = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
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
        <?php if (isset($_SESSION['user'])): ?>
        .hero-content .btn {
            display: none; /* Hide buttons for logged in users */
        }
        .auth {
            display: block; /* Show auth buttons for logged in users */
        }
        .non-auth {
            display: none; /* Hide non-auth buttons for logged in users */
        }
        <?php else: ?>
        .auth {
            display: none; /* Hide auth buttons for non-logged in users */
        }
        .non-auth {
            display: block; /* Show non-auth buttons for non-logged in users */
        }
        <?php endif; ?>

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

    <section class="container py-5">
    <!-- Marathon Title -->
    <h2 class="text-center mb-4">Marathons 2024</h2>
    <!-- Dropdown List of Marathons -->
    <div class="accordion" id="raceAccordion">

        <!-- Races -->
        <?php foreach ($list_races as $race): ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?php echo $race['id']; ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $race['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $race['id']; ?>">
                    <?php echo $race['race_name']; ?>
                </button>
            </h2>
            <div id="collapse<?php echo $race['id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $race['id']; ?>" data-bs-parent="#raceAccordion">
                <div class="accordion-body">
                    <!-- Grid of images -->
                    <div class="row g-4">
                        <!-- Image & Description 1 -->
                        
                            <?php foreach ($race['images'] as $image): ?>
                            <div class="col-md-4 col-sm-6">
                                <a href="#" class="image-link " data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-img="<?php echo substr($image['url'],1); ?>" data-bs-desc="<?php echo $image['description']; ?>">
                                    <img src="<?php echo substr($image['url'],1); ?>" class="img-fluid rounded" alt="Image 1">
                                </a>
                            </div>
                            <?php endforeach; ?>
                        
                    </div>
                    <div class="text-center mt-4">
                        <a href="raceregister.php?id=<?php echo $race['id'] ?>" class="btn btn-primary btn-lg">Register for <?php echo $race['race_name'] ?> </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>    
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