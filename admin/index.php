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
    $user_info = $admin->getAdminById($_SESSION['user']['id']);
    if (!$user_info['admin']) {
        header('Location: login.php');
        $_SESSION['error'] = 'You must be an admin to access this page';
        exit;
    }
}

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
    <title>Admin</title>
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
        /* background-color: black; */
        height: 20vh;
    }
    .card-header {
        font-size: 1.5rem;
        background-color: #fff;
    }
    .card-body {
        font-size: 0.8rem;
    }
    .btn-link {
        font-size: 0.8rem;
    }
    .stat-card {
        text-align: center;
        background-color: #f1f1f1;
        padding: 20px;
        margin-bottom: 15px;
    }
    .stat-card .count {
        font-size: 2rem;
        font-weight: bold;
    }
    .table th, .table td {
        text-align: center;
        
    }
    .table td a {
        margin-right: 5px;
    }
    .list-course {
        background-color: #f1f1f1;

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
    <!-- Dashboard Header -->
    <div class="row">
        <div class="col-12  mb-4">
            <h1>Admin Dashboard</h1>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h5>Total Courses</h5>
                    <div class="count">12</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h5>Total Participants</h5>
                    <div class="count">248</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h5>Upcoming Races</h5>
                    <div class="count">5</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Race Course Table -->
    <div class="card list-course">
        <div class="card-header">
            <h4>Race Courses</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Total Members</th>
                        <th>Status</th>
                        <th>Winner</th>
                        <th>Start Registration</th>
                        <th>End Registration</th>
                        <th>Start Race</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Data Row -->
                    <tr>
                        <td>1</td>
                        <td>Spring Marathon 2024</td>
                        <td>150</td>
                        <td>Registration Time</td>
                        <td></td>
                        <td>2024-04-01</td>
                        <td>2024-04-05</td>
                        <td>2024-04-10 09:00</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                            <a href="#" class="btn btn-secondary btn-sm">Gallery</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Summer Sprint 2024</td>
                        <td>200</td>
                        <td>Coming Soon</td>
                        <td></td>
                        <td>2024-05-01</td>
                        <td>2024-05-10</td>
                        <td>2024-05-15 09:00</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                            <a href="#" class="btn btn-secondary btn-sm">Gallery</a>
                        </td>
                    </tr>
                    <!-- Add more rows here as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>