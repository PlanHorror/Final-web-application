<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/src/' . $class_name . '.php';
});
$user = new User();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $user->login($_POST);
    if (empty($res['errors'])) {
        // Authenticate user
        
        $user = $user->getUserByName($_POST['username']);
        $_SESSION['user'] = $user;
        $_SESSION['success'] = 'You are now logged in';
        header('Location: index.php');
        exit;
    } else {
        $errors = $res['errors'];
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
    <title>Login</title>
    <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous" />
  <style>
    body {
        background-image: url('https://img.freepik.com/free-photo/blue-concrete-wall-texture-background_53876-145494.jpg?t=st=1732945156~exp=1732948756~hmac=c1d9969fb5e16f6104a39bea2c9d132e5c6778a31d716e6be1772bb23576e44a&w=1380')
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
        border-radius: 20px 0px 0px 20px;
    }
    img {
        width: 100%;
        height: 100%;
        border-radius: 0px 20px 20px 0px;
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
    .error {
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
    <div class="container" style="height: 80vh; width:60vw">
        <div class="row h-100">
            <div class="col-12 d-flex justify-content-center align-items-center h-100">
                <div class="blur-background d-flex w-100 h-100">
                    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
                        <div class="bg-light p-5 w-100 h-100 lbg">
                            <form method="POST" action="" class="login-form">
                                <div class="title-form"><h2>Login</h2></div>
                                
                                <div class="input-form" >
                                    <input type="text" class="form-control h-100" id="username" name="username" placeholder="Username" required style="font-size: 110%;">
                                    <input type="password" class="form-control h-100" id="password" name="password" placeholder="Password" required style="font-size: 110%;">
                                </div>
                                <div class="submit-form">
                                    <button type="submit" class="btn btn-primary w-100" style="font-size:110%;">Login</button>
                                </div>
                                <div class="register-form">
                                    <a href="register.php" style="font-size: 100%;">Don't have an account? Register</a>
                                </div>
                                <?php if (!empty($errors)): ?>
                                        <ul>
                                            <?php foreach ($errors as $error): ?>
                                                <li class="error"><?php echo htmlspecialchars($error); ?></li>
                                            <?php endforeach;  ?>
                                        </ul>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center img">
                        <img src="https://as1.ftcdn.net/v2/jpg/02/74/96/22/1000_F_274962214_Vn3bT2SMFWrujUtdfa3ZImipjYoy5wsR.jpg" alt="Login Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
