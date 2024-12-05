<?php
spl_autoload_register(function ($class) {
    require_once 'src/' . $class . '.php';
});
session_start();
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = 'You need to login first';
    header('Location: login.php');
    exit;
}
$user = new User();
$user_info = $user->getUserById($_SESSION['user']['id']);
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
    .non-auth {
        display: none;
    }
    </style>
</head>
<body>
    <?php include 'template/navbar.html'; ?>
    <?php include 'template/message.php'; ?>
    <div class="container information">
        <div class="row h-100">
            <div class="col-12 d-flex justify-content-center align-items-center h-100">
                <div class="blur-background d-flex w-100 h-100">
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <div class="bg-light p-5 w-100 h-100 lbg">
                            <h2 class="text-center mb-5">User Information</h2>
                            
                            <!-- Full Name -->
                            <div class="mb-4">
                                <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Full Name:</span>
                                <span style="font-size: 1.5rem; display: inline-block;">
                                    <?php echo htmlspecialchars($user_info['name']); ?>
                                </span>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Email:</span>
                                <span style="font-size: 1.5rem; display: inline-block;">
                                    <?php echo htmlspecialchars($user_info['email']); ?>
                                </span>
                            </div>

                            <!-- Nationality -->
                            <div class="mb-4">
                                <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Nationality:</span>
                                <span style="font-size: 1.5rem; display: inline-block;">
                                    <?php echo htmlspecialchars($user_info['nationality']); ?>
                                </span>
                            </div>

                            <!-- Gender -->
                            <div class="mb-4">
                                <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Gender:</span>
                                <span style="font-size: 1.5rem; display: inline-block;">
                                    <?php echo htmlspecialchars($user_info['gender']); ?>
                                </span>
                            </div>
                            <!-- Age -->
                            <div class="mb-4">
                                <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Age:</span>
                                <span style="font-size: 1.5rem; display: inline-block;">
                                    <?php echo htmlspecialchars($user_info['age']); ?>
                                </span>
                            </div>

                            <!-- Best Record -->
                            <div class="mb-4">
                                <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Best Record:</span>
                                <span style="font-size: 1.5rem; display: inline-block;">
                                    <?php echo htmlspecialchars($user_info['best_record']); ?>
                                </span>
                            </div>

                            <!-- Passport Number -->
                            <div class="mb-4">
                                <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Passport No:</span>
                                <span style="font-size: 1.5rem; display: inline-block;">
                                    <?php echo htmlspecialchars($user_info['passport_no']); ?>
                                </span>
                            </div>

                            <!-- Address -->
                            <div class="mb-4">
                                <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Address:</span>
                                <span style="font-size: 1.5rem; display: inline-block;">
                                    <?php echo htmlspecialchars($user_info['address']); ?>
                                </span>
                            </div>
                            
                            <!-- Phone Number -->
                            <div class="mb-4">
                                <span style="font-size: 1.5rem; width: 150px; font-weight: bold; display: inline-block;">Phone Number:</span>
                                <span style="font-size: 1.5rem; display: inline-block;">
                                    <?php echo htmlspecialchars($user_info['phone_number']); ?>
                                </span>
                            </div>

                            <!-- Race History -->
                            <div class="mb-5 text-center">
                                <h3 class="text-center mb-4">Race History</h3>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Entry #</th>
                                            <th scope="col">Race Name</th>
                                            <th scope="col">Time Record</th>
                                            <th scope="col">Standings</th>
                                            <th scope="col">Hotel Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $race_history = $user->getUserAchievements($_SESSION['user']['id']);
                                        if ($race_history){
                                           foreach ($race_history as $race) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($race['entry_number']) . '</td>';
                                            echo '<td>' . htmlspecialchars($race['race_name']) . '</td>';
                                            echo '<td>' . htmlspecialchars($race['time_record']) . '</td>';
                                            echo '<td>' . htmlspecialchars($race['standings']) . '</td>';
                                            echo '<td>' . htmlspecialchars($race['hotel_name']) . '</td>';
                                            echo '</tr>';
                                        } 
                                        } else {
                                            echo '<tr><td colspan="5" class="text-center">No race history available.</td></tr>';
                                        }
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Buttons -->
                            <div class="mb-5 text-center">
                                <a href="editprofile.php" class="btn btn-primary w-100" style="font-size: 1.5rem;">Edit Profile</a>
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

