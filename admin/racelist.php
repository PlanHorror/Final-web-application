<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../src/' . $class_name . '.php';
});
session_start();
$db = new Database();
$admin = new Admin();
$race = new Race();
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
$all_races = $race->getRaces();
$successMessage = $_SESSION["success"] ?? null;
unset($_SESSION['success']);
$errorMessage = $_SESSION["error"] ?? null;
unset($_SESSION['error']);
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
        .gallery {
            margin-top: 10px;
            justify-content: center;
        }
        .gallery img {
            width: 100%;
            max-width: 390px;
            margin: 5px;
            cursor: pointer;
            border-radius: 20px;
        }

        .gallery img:hover {
            transform: scale(1.1);
            transition: transform 0.2s;
        }

        .gallery-item {
            align-items: center;
            margin: 15px;
            max-width: 30%;
        }

        .gallery-item p {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
            margin-left: 5px;
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

                    <?php foreach ($all_races as $race): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#race<?php echo $race['id'] ?>" aria-expanded="false" aria-controls="#race<?php echo $race['id'] ?>">
                                <?php echo $race['race_name']; ?>
                            </button>
                        </h2>
                        <div id="race<?php echo $race['id'] ?>" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#raceAccordion">
                            <div class="accordion-body">
                                <!-- Race Info -->
                                <h5>Race Information</h5>
                                <p><strong>Status:</strong> <?php echo $race['status']; ?></p>
                                <p><strong>Start Race:</strong> <?php echo $race['race_start']; ?></p>
                                <p><strong>Total Participants:</strong> <?php echo $race['total_participants']; ?></p>
                                <p><strong>Winner:</strong> <?php echo $race['winner']['name'] ?? 'No winner yet'; ?></p>
                                <!-- Standing Table -->
                                <!-- <h5>Standings</h5>
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
                                </table> -->

                                <!-- Gallery -->
                                <h5>Gallery</h5>
                                <div class="gallery d-flex flex-wrap">
                                    <?php foreach ($race['images'] as $image): ?>
                                        <div class="gallery-item">
                                            <img src="<?php echo $image['url']; ?>" alt="<?php echo htmlspecialchars($image['description']); ?>" class="img-fluid">
                                            <p><?php echo htmlspecialchars($image['description']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($race['images']) === 0) : ?>
                                    <p>No images available</p>
                                <?php endif; ?>                                    
                                <!-- Buttons -->
                                <div class="mt-4">
                                    <a href="editrace.php?id=<?php echo $race['id'] ?>" class="btn btn-info">Edit</a>
                                    <a href="deleterace.php?id=<?php echo $race['id'] ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                        
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
