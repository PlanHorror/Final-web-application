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
$users = $admin->getAllUsers() ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
    <style>
        body {
            background-image: url('../media/background.jpg');
            background-size: cover;
            background-attachment: fixed;
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
        .card-header {
            font-size: 1.5rem;
            background-color: #fff;
            color: black;
            font-weight: bold;
        }
        .card-body {
            font-size: 0.9rem;
        }
        .btn-link {
            font-size: 0.8rem;
        }
        .non-auth {
        display: none;
        }   
    </style>
</head>
<body>
    <div class="container">
        <?php include '../template/admin-navbar.html'; ?>
        <?php include '../template/message.php'; ?>
        <div class="row">
            <div class="col-12">
                <div class="banner"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h1 class="text-center text-white">User List</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="main">
                    <div class="card shadow">
                        <div class="card-header text-center">
                            User List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Nationality</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Age</th>
                                            <th scope="col">Passport No</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Best Record</th>
                                            <th scope="col">Total Races</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($users)) : ?>
                                            <tr>
                                                <td colspan="14" class="text-center text-muted">
                                                    <i class="bi bi-info-circle"></i> No users found
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php foreach ($users as $user) : ?>
                                            <tr>
                                                <td><?= array_search($user, $users) + 1 ?></td>
                                                <td><?= htmlspecialchars($user['name']) ?></td>
                                                <td><?= htmlspecialchars($user['email']) ?></td>
                                                <td><?= htmlspecialchars($user['nationality'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['gender'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['age'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['passport_no'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['address'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['phone_number'] ?? 'N/A') ?></td>
                                                <td><?= $user['admin'] ? 'Admin' : 'User' ?></td>
                                                <td><?= htmlspecialchars($user['best_record'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['total_race'] ?? '0') ?></td>
                                                <td><?= htmlspecialchars($user['create_at']) ?></td>
                                                <td>
                                                    <a href="deleteuser.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" aria-label="Delete User <?= $user['name'] ?>">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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


