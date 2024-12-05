<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../src/' . $class_name . '.php';
});
session_start();
$db = new Database();
$admins = new Admin();
// Check if user is logged in
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['admin']) {
        header('Location: index.php');
        $_SESSION['error'] = 'You are already logged in';
        exit;
    } else {
        unset($_SESSION['user']);
        unset($_SESSION['success']);
        unset($_SESSION['error']);
        header('Location: login.php');
        $_SESSION['error'] = 'Your account does not have the necessary permissions to access this page';
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $admins->login($_POST);
    if (empty($res['errors'])) {
        $admin = $admins->getAdminByEmail($_POST['email']);
        // Authenticate user
        $_SESSION['user'] = $admin;
        $_SESSION['success'] = 'You are now logged in';
        header('Location: index.php');
        exit;
    } else {
        $errors = $res['errors'] ?? [];
    }
    
}
$successMessage = $_SESSION["success"] ?? null;
unset($_SESSION['success']);
$errorMessage = $_SESSION['error'] ?? null; 
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous" />
  <style>
    body {
        background-image: url('../media/background.jpg');
    }
    input {
        font-size: 1.25rem;
        margin-bottom: 5%;
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
    .login-form {
        height: 100%;
    }
    .input-form {
        margin: 10% 0% 10% 0%;
    }
    .title-form {
        margin: 5% 0% 10% 0%;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 15%;
    }
    .submit-form {
        margin: 10% 0% 5% 0%;
        height: 15%;
    }
    .register-form {
        margin: 5% 0% 5% 0%;
        height: 10%;
        text-align: center;
    }
    .error-login {
        color: red;
        font-size: 90%;
        height: 15%;
    }
    .auth {
        display: none;
    }
    .non-auth {
        display: block;
    }
    </style>
</head>
<body>
    <?php include '../template/admin-navbar.html'; ?>
    <?php include '../template/message.php'; ?>
    <div class="container-fluid banner">
    </div>
    <div class="container" style=" width:40vw">
        <div class="row h-100">
            <div class="col-12 d-flex justify-content-center align-items-center h-100">
                <div class="blur-background d-flex w-100 h-100">
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <div class="bg-light p-5 w-100 h-100 lbg">
                            <form method="POST" action="">
                                <h2 class="text-center mb-5">Login</h2>
                                <div class="mb-4">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required style="font-size: 1.5rem;">
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required style="font-size: 1.5rem;">
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary w-100" style="font-size: 1.5rem;">Login</button>
                                </div>
                                <?php if (!empty($errors)): ?>
                                        <ul>
                                            <?php foreach ($errors as $error): ?>
                                                <li class="error-login"><?php echo htmlspecialchars($error); ?></li>
                                            <?php endforeach;?>
                                        </ul>
                                <?php endif;?>
                            </form>
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
