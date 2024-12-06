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
        exit;
    } else {
        $errors = $res['errors'];
    }

}
$successMessage = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
$errorMessage = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
// $countryList = file_get_contents('https://api.first.org/data/v1/countries');
$countryList = file_get_contents('data/countries.json');
$countries = json_decode($countryList, true)['data'];
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
            background-image: url('media/background.jpg');
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
            border-radius: 20px;
        }
        .error-login {
            color: red;
            font-size: 90%;
            height: 15%;
        }
        .auth {
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'template/navbar.html'; ?>
    <?php include 'template/message.php'; ?>
    <div class="container-fluid banner">
    </div>
    <div class="container">
        <div class="row ">
            <div class="col-12 d-flex justify-content-center align-items-center h-100">
                <div class="blur-background d-flex w-100 h-100">
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <div class="bg-light p-5 w-100 h-100 lbg">
                            <form method="POST" action="">
                                <h2 class="text-center mb-5">Register</h2>

                                <!-- Full Name -->
                                <div class="mb-4">
                                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name" required style="font-size: 1.5rem;">
                                </div>
                                <!-- Age -->
                                <div class="mb-4">
                                    <input type="number" class="form-control" id="age" name="age" placeholder="Age" required min="1" style="font-size: 1.5rem;">
                                </div>
                                <!-- Nationality (Dropdown) -->
                                <div class="mb-4">
                                    <select class="form-control" id="nationality" name="nationality" required style="font-size: 1.5rem;">
                                        <option value="" disabled selected>Select Nationality</option>
                                        <!-- API will populate this dropdown -->
                                        <?php foreach ($countries as $key => $value): ?>
                                            <option value="<?php echo htmlspecialchars($value['country']); ?>"><?php echo htmlspecialchars($value['country']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Gender (Radio Buttons) -->
                                <div class="mb-4">
                                    
                                    <input type="radio" id="male" name="gender" value="Male" required> Male
                                    <input type="radio" id="female" name="gender" value="Female"> Female
                                    <input type="radio" id="other" name="gender" value="Other"> Other
                                </div>

                                <!-- Passport Number (Optional) -->
                                <div class="mb-4">
                                    <input type="text" class="form-control" id="passportNO" name="passportNO" placeholder="Passport Number (Optional)" style="font-size: 1.5rem;">
                                </div>

                                <!-- Address -->
                                <div class="mb-4">
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" required style="font-size: 1.5rem;">
                                </div>

                                <!-- Phone Number -->
                                <div class="mb-4">
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" required style="font-size: 1.5rem;">
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required style="font-size: 1.5rem;">
                                </div>

                                <!-- Password -->
                                <div class="mb-4 position-relative">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required style="font-size: 1.5rem;">
                                    <i class="fas fa-eye" id="togglePassword" style="position: absolute; top: 50%; right: 10px; cursor: pointer;"></i>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required style="font-size: 1.5rem;">
                                </div>

                                <!-- Register Button -->
                                <div class="mb-5">
                                    <button type="submit" class="btn btn-primary w-100" style="font-size:1.5rem;">Register</button>
                                </div>

                                <!-- Login Link -->
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

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('confirm_password');

        togglePassword.addEventListener('click', function (e) {
            // Toggle the type attribute
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            confirmField.setAttribute('type', type);

            // Toggle the eye icon
            this.classList.toggle('fa-eye-slash');
        });

    </script>
</body>
</html>
