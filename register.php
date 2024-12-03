<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/src/' . $class_name . '.php';
});
$user = new User();
session_start();
// Check if user is logged in
// if (isset($_SESSION['user'])) {
//     header('Location: index.php');
//     $_SESSION['error'] = 'You are already logged in';
//     exit;
// }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $user->register($_POST);
    if (empty($res['errors'])) {
        $_SESSION['success'] = 'You are now registered and can log in';
        header('Location: login.php');
        exit;
    } else {
        $errors = $res['errors'];
    }

}
$successMessage = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous" />
  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
  rel="stylesheet" />
  <style>
    body {
        /* background-color: #0b2447; */
        background-image: url('media/background.jpg')
    }
    .banner {
        height: 150px;
    }
    .blur-background {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 20px;
    }
    .lbg {
        border-radius: 20px 20px 20px 20px;
    }
    img {
        width: 100%;
        height: 100%;
        border-radius: 0px 20px 20px 0px;
    }
    .error-login {
        color: red;
        font-size: 90%;
        height: 15%;
    }
  </style>
</head>
<body>
    <?php include 'template/navbar.html'; ?>
    <?php include 'template/message.php'; ?>
    <div class="container-fluid banner">
    </div>
    <div class="container" style="">
        <div class="row h-100">
            <div class="col-12 d-flex justify-content-center align-items-center h-100">
                <div class="blur-background d-flex w-100 h-100">
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <div class="bg-light p-5 w-100 h-100 lbg">
                            <form method="POST" action="">
                                <h2 class="text-center mb-5">Register</h2>
                                <div class="mb-4">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required style="font-size: 1.5rem;">
                                </div>
                                <div class="mb-4">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required style="font-size: 1.5rem;">
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required style="font-size: 1.5rem;">
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required style="font-size: 1.5rem;">
                                </div>
                                <div class="mb-5">
                                    <button type="submit" class="btn btn-primary w-100" style="font-size:1.5rem;">Register</button>
                                </div>

                                <div class="mb-5 text-center">
                                    <a href="login.php" style="font-size: 1.2rem;">Have an account? Login</a>
                                </div>
                                <?php if (!empty($errors)): ?>
                                        <ul>
                                            <?php foreach ($errors as $error): ?>
                                                <li class="error-login"><?php echo htmlspecialchars($error); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                <?php endif; ?>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>