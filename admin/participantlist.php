<?php
session_start();
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../src/' . $class_name . '.php';
});
$db = new Database();
$race = new Race();
$admin = new Admin();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    $_SESSION['error'] = 'You must be logged in to access this page';
    exit;
} else {
    $user = $admin->getAdminById($_SESSION['user']['id']);
    if (!$user['admin']) {
        header('Location: login.php');
        $_SESSION['error'] = 'You must be an admin to access this page';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registrations</title>
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
                <h1>Registered Users</h1>
            </div>
        </div>

        <!-- Race Registration Dropdowns -->
        <div class="accordion" id="raceAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSpringMarathon">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSpringMarathon" aria-expanded="true" aria-controls="collapseSpringMarathon">
                        Spring Marathon 2024
                    </button>
                </h2>
                <div id="collapseSpringMarathon" class="accordion-collapse collapse show" aria-labelledby="headingSpringMarathon" data-bs-parent="#raceAccordion">
                    <div class="accordion-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry Number</th>
                                    <th>Username</th>
                                    <th>Nationality</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Race Bib</th>
                                    <th>Passport No</th>
                                    <th>Address</th>
                                    <th>Mobile Phone</th>
                                    <th>Hotel Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>USA</td>
                                    <td>Male</td>
                                    <td>30</td>
                                    <td>1234</td>
                                    <td>A12345678</td>
                                    <td>123 Main Street, New York, NY</td>
                                    <td>+1 123 456 7890</td>
                                    <td>Grand Hotel</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSummerSprint">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSummerSprint" aria-expanded="false" aria-controls="collapseSummerSprint">
                        Summer Sprint 2024
                    </button>
                </h2>
                <div id="collapseSummerSprint" class="accordion-collapse collapse" aria-labelledby="headingSummerSprint" data-bs-parent="#raceAccordion">
                    <div class="accordion-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry Number</th>
                                    <th>Username</th>
                                    <th>Nationality</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Race Bib</th>
                                    <th>Passport No</th>
                                    <th>Address</th>
                                    <th>Mobile Phone</th>
                                    <th>Hotel Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Jane Smith</td>
                                    <td>UK</td>
                                    <td>Female</td>
                                    <td>27</td>
                                    <td>5678</td>
                                    <td>B98765432</td>
                                    <td>456 Elm Street, London</td>
                                    <td>+44 20 7946 0958</td>
                                    <td>Royal Inn</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
hotel_name