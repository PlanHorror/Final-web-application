<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../src/' . $class_name . '.php';
});
session_start();
$db = new Database();
$admin = new Admin();
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    $_SESSION['error'] = 'You must be logged ';
    exit;
} else {
    $user = $admin->getAdminById($_SESSION['user']['id']);
    if (!$user['admin']) {
        header('Location: login.php');
        $_SESSION['error'] = 'You must be an admin to access this page';
        exit;
    }
}

$successMessage = $_SESSION["success"] ?? null;
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Race List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url('../media/background.jpg');
        }
        h1 {
            font-size: 2.5rem;
            color: #fff;
        }
        .main {
            padding: 20px;
        }
        .banner {
            height: 20vh;
        }
        .list-course {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
        }
        .gallery img {
            width: 100%;
            max-width: 150px;
            margin: 5px;
            cursor: pointer;
        }
        .gallery img:hover {
            transform: scale(1.1);
            transition: transform 0.2s;
        }
        .non-auth {
        display: none;
        }   
    </style>
</head>
<body>
    <?php include '../template/admin-navbar.html'; ?>
    <?php include '../template/message.php'; ?>

    <div class="container-fluid banner"></div>  
    <div class="container mt-4 main">
        <div class="row">
            <div class="col-12 mb-4">
                <h1>Race List</h1>
            </div>
        </div>

        <div class="card list-course">
            <div class="card-header">
                <h4>Race Courses</h4>
            </div>
            <div class="card-body">
                <!-- Race Dropdown -->
                <div class="accordion" id="raceAccordion">

                    <!-- Coming Soon Race -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#race1" aria-expanded="true" aria-controls="race1">
                                Spring Marathon 2024
                            </button>
                        </h2>
                        <div id="race1" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#raceAccordion">
                            <div class="accordion-body">
                                <!-- Race Info -->
                                <h5>Race Information</h5>
                                <p><strong>Status:</strong> Coming Soon</p>
                                <p><strong>Start Registration:</strong> 2024-04-01</p>
                                <p><strong>End Registration:</strong> 2024-04-05</p>
                                <p><strong>Start Race:</strong> 2024-04-10 09:00</p>

                                <!-- Standing Table -->
                                <h5>Standings</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Entry number</th>
                                            <th>Name</th>
                                            <th>Time Record</th>
                                            <th>Standings</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="text-center">No data now</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Gallery -->
                                <h5>Gallery</h5>
                                <div class="gallery d-flex flex-wrap">
                                    <img src="../media/image1.jpg" alt="Race Image 1">
                                    <img src="../media/image2.jpg" alt="Race Image 2">
                                    <img src="../media/image3.jpg" alt="Race Image 3">
                                    <img src="../media/image4.jpg" alt="Race Image 4">
                                    <img src="../media/image5.jpg" alt="Race Image 5">
                                    <img src="../media/image6.jpg" alt="Race Image 6">
                                </div>

                                <!-- Buttons -->
                                <div class="mt-3">
                                    <a href="#" class="btn btn-info">Edit</a>
                                    <a href="#" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scoring Time Race -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#race2" aria-expanded="false" aria-controls="race2">
                                Summer Sprint 2024
                            </button>
                        </h2>
                        <div id="race2" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#raceAccordion">
                            <div class="accordion-body">
                                <!-- Race Info -->
                                <h5>Race Information</h5>
                                <p><strong>Status:</strong> Scoring Time</p>
                                <p><strong>Start Registration:</strong> 2024-05-01</p>
                                <p><strong>End Registration:</strong> 2024-05-10</p>
                                <p><strong>Start Race:</strong> 2024-05-15 09:00</p>

                                <!-- Standing Table -->
                                <h5>Standings</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Entry number</th>
                                            <th>Name</th>
                                            <th>Time Record</th>
                                            <th>Standings</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>20241</td>
                                            <td>John Doe</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>20242</td>
                                            <td>Jane Doe</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Gallery -->
                                <h5>Gallery</h5>
                                <div class="gallery d-flex flex-wrap">
                                    <img src="../media/image7.jpg" alt="Race Image 1">
                                    <img src="../media/image8.jpg" alt="Race Image 2">
                                    <img src="../media/image9.jpg" alt="Race Image 3">
                                    <img src="../media/image10.jpg" alt="Race Image 4">
                                    <img src="../media/image11.jpg" alt="Race Image 5">
                                    <img src="../media/image12.jpg" alt="Race Image 6">
                                </div>

                                <!-- Buttons -->
                                <div class="mt-3">
                                    <a href="#" class="btn btn-info">Edit</a>
                                    <a href="#" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add more races as needed -->
                     <!-- Ended Race -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#race3" aria-expanded="false" aria-controls="race3">
                                Autumn Challenge 2024
                            </button>
                        </h2>
                        <div id="race3" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#raceAccordion">
                            <div class="accordion-body">
                                <!-- Race Info -->
                                <h5>Race Information</h5>
                                <p><strong>Status:</strong> Ended</p>
                                <p><strong>Start Registration:</strong> 2024-03-01</p>
                                <p><strong>End Registration:</strong> 2024-03-05</p>
                                <p><strong>Start Race:</strong> 2024-03-10 09:00</p>

                                <!-- Standing Table -->
                                <h5>Standings</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Entry number</th>
                                            <th>Name</th>
                                            <th>Time Record</th>
                                            <th>Standings</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Michael Brown</td>
                                            <td>2:15:45</td>
                                            <td>1st</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>John Doe</td>
                                            <td>2:18:30</td>
                                            <td>2nd</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Tom Hanks</td>
                                            <td>2:20:00</td>
                                            <td>3rd</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Gallery -->
                                <h5>Gallery</h5>
                                <div class="gallery d-flex flex-wrap">
                                    <img src="../media/image13.jpg" alt="Race Image 1">
                                    <img src="../media/image14.jpg" alt="Race Image 2">
                                    <img src="../media/image15.jpg" alt="Race Image 3">
                                    <img src="../media/image16.jpg" alt="Race Image 4">
                                    <img src="../media/image17.jpg" alt="Race Image 5">
                                    <img src="../media/image18.jpg" alt="Race Image 6">
                                </div>

                                <!-- Buttons -->
                                <div class="mt-3">
                                    <a href="#" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
