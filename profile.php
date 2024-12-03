<?php
spl_autoload_register(function ($class) {
    require_once 'src/' . $class . '.php';
});
session_start();
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = new User();
$user_info = $user->getUserById($_SESSION['user']['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous" />
  <style>
    body {
        background-image: url('media/background.jpg')
    }
    .information {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 20px;
        margin-top: 150px;
    }
    .lbg {
        border-radius: 20px 0px 0px 20px;
    }
    </style>
</head>
<body>
    <?php include 'template/navbar.html'; ?>

    <div class="container information">
    <div class="row h-100">
        <div class="col-12 d-flex justify-content-center align-items-center h-100">
            <div class="blur-background d-flex w-100 h-100">
                <div class="col-md-12 d-flex justify-content-center align-items-center">
                    <div class="bg-light p-5 w-100 h-100 lbg">
                        <h2 class="text-center mb-5">User Information</h2>
                        
                        <!-- Username Field -->
                        <div class="mb-4">
                            <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Username:</span>
                            <span style="font-size: 1.5rem; display: inline-block;">
                                <?php echo htmlspecialchars($user_info['username']); ?>
                            </span>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Email:</span>
                            <span style="font-size: 1.5rem; display: inline-block;">
                                <?php echo htmlspecialchars($user_info['email']); ?>
                            </span>
                        </div>

                        <!-- Joined Date Field -->
                        <div class="mb-4">
                            <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Joined on:</span>
                            <span style="font-size: 1.5rem; display: inline-block;">
                                <?php echo date('F j, Y', strtotime($user_info['create_at']));?>
                            </span>
                        </div>

                        <div class="mb-5 text-center">
                            <h3 class="text-center mb-4">Achievements</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Achievement</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // $achievements = $user->getUserAchievements($_SESSION['user']['id']);
                                    $achievements = [['title' => 'First Marathon', 'date' => '2022-01-01']];
                                    foreach ($achievements as $index => $achievement) {
                                        echo '<tr>';
                                        echo '<th scope="row">' . (1) . '</th>';
                                        echo '<td>' . htmlspecialchars($achievement['title']) . '</td>';
                                        echo '<td>' . date('F j, Y', strtotime($achievement['date'])) . '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                                <!-- Buttons -->
                        <div class="mb-5 text-center">
                            <a href="edit_profile.php" class="btn btn-primary w-100" style="font-size: 1.5rem;">Edit Profile</a>
                        </div>

                        <div class="mb-5 text-center">
                            <a href="logout.php" class="btn btn-secondary w-100" style="font-size: 1.5rem;">Logout</a>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>