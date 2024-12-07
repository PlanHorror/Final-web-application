<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/src/' . $class_name . '.php';
});
$db = new Database();
$user = new User();
$races = new Race();
session_start();
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    $_SESSION['error'] = 'You must be logged in to register for a race';
    exit;
}
$race_id = $_GET['id'] ?? null;
$race = $races->getRaceById($race_id) ?? null;

if (!$race_id|| !$race) {
    header('Location: index.php');
    $_SESSION['error'] = 'Race not found';
    exit;
}
// Compare race_start date with today's date
$today = date('Y-m-d' . 'H:i:s');
if ($race['race_start'] < $today) {
    header('Location: index.php');
    $_SESSION['error'] = 'Race has already ended';
    exit;
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo($race_id);
    $errors = $races->registerRace($race_id, $race['entry_prefix'] , $_SESSION['user']['id'], $_POST['hotel']);
    if (empty($errors)) {
        $_SESSION['success'] = "Welcome," . $_SESSION['user']['name'] . "🎉 You've successfully registered for the" . $race['race_name'] . "! Get ready to hit the starting line on " . $race['race_start'] . ". 🏁 Let the countdown begin!";
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-image: url('media/background.jpg');
        }
        .blur-background {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border-radius: 20px;
            padding: 20px;
            margin-top: 10vh;
        }
        .lbg {
            border-radius: 20px;
        }
        .icon-banner {
            font-size: 4rem;
            color: #007bff;
        }
        .motivational-text {
            font-size: 1.25rem;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .progress-bar {
            background-color: #007bff;
            height: 5px;
            margin-bottom: 20px;
        }
        .non-auth {
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'template/navbar.html'; ?>
    <?php include 'template/message.php'; ?>

    <!-- Register Race Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="blur-background col-md-8">
                <div class="p-5 bg-light lbg">
                    <div class="text-center">
                        <i class="fas fa-running icon-banner"></i>
                        <h2 class="my-4">Register for the <?php echo $race['race_name'] ?></h2>
                        <p class="motivational-text">Take the first step toward an unforgettable journey. Let’s race to the finish line together!</p>
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress-bar"></div>

                    <form method="POST" action="">
                        <!-- Required Field -->
                        <div class="mb-4">
                            <label for="hotel" class="form-label" style="font-size: 1.25rem;">Hotel Name (Optional)</label>
                            <input type="text" class="form-control" id="hotel" name="hotel" placeholder="Enter your hotel name" >
                        </div>


                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100" style="font-size: 1.25rem;">Submit</button>
                        </div>

                        <!-- Error Messages -->
                        <?php if ($errors): ?>
                            <ul class="mt-4">
                                <li class="text-danger"><?php echo htmlspecialchars($errors); ?></li>
                            </ul>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
