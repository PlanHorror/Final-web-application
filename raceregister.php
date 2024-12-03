<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/src/' . $class_name . '.php';
});
$db = new Database();
$user = new User();
session_start();
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    $_SESSION['error'] = 'You must be logged in to register for a race';
    exit;
}
// Fetch country list from API
$countryList = file_get_contents('https://api.first.org/data/v1/countries');
$countries = json_decode($countryList, true)['data'];
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('national');
    const countries = <?php echo json_encode($countries); ?>;
    
    for (const code in countries) {
        if (countries.hasOwnProperty(code)) {
            const option = document.createElement('option');
            option.value = code;
            option.text = countries[code].country;
            countrySelect.appendChild(option);
        }
    }
});
</script>
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
        border-radius: 20px 20px 20px 20px;
    }
    img {
        width: 100%;
        height: 100%;
        border-radius: 0px 20px 20px 0px;
    }
    .error {
        color: red;
        font-size: 1.25rem;
    }
    .success {
        color: green;
        font-size: 1.25rem;
    }
    </style>
</head>
<body>
    <?php include 'template/navbar.html'; ?>
    <?php include 'template/message.php'; ?>
    <div class="container-fluid banner">
    </div>

<!-- Register Race Form -->
<div class="container">
    <div class="row h-100">
        <div class="col-12 d-flex justify-content-center align-items-center h-100">
            <div class="blur-background d-flex w-100 h-100">
                <div class="col-md-12 d-flex justify-content-center align-items-center">
                    <div class="bg-light p-5 w-100 h-100 lbg">
                        <form method="POST" action="">
                            <h2 class="text-center mb-5">Register for Marathon</h2>
                            
                            <!-- Full Name -->
                            <div class="mb-4">
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" required style="font-size: 1.5rem;">
                            </div>

                            <!-- Nationality -->
                            <div class="mb-4">
                                <select class="form-select" id="national" name="national" required style="font-size: 1.5rem;">
                                    <option value="" disabled selected>Select your nationality</option>
                                    <option value="VN">Vietnam</option>
                                    <option value="US">United States</option>
                                    <option value="IN">India</option>
                                    <option value="JP">Japan</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                            <!-- Gender -->
                            <div class="mb-4">
                                <div class="form-check d-inline-block me-4">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check d-inline-block me-4">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="Female" required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check d-inline-block">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="Other" required>
                                    <label class="form-check-label" for="other">Other</label>
                                </div>
                            </div>


                            <!-- Age -->
                            <div class="mb-4">
                                <input type="number" class="form-control" id="age" name="age" placeholder="Age" min="18" required style="font-size: 1.5rem;">
                            </div>

                            <!-- Passport Number -->
                            <div class="mb-4">
                                <input type="number" class="form-control" id="passportNo" name="passportNo" placeholder="Passport Number" required style="font-size: 1.5rem;">
                            </div>

                            <!-- Mobile Number -->
                            <div class="mb-4">
                                <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required style="font-size: 1.5rem;">
                            </div>

                            <!-- Hotel Name -->
                            <div class="mb-4">
                                <input type="text" class="form-control" id="hotel" name="hotel" placeholder="Hotel Name" required style="font-size: 1.5rem;">
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary w-100" style="font-size:1.5rem;">Submit</button>
                            </div>

                            <!-- Error Messages -->
                            <?php if (!empty($errors)): ?>
                                <ul>
                                    <?php foreach ($errors as $error): ?>
                                        <li class="error"><?php echo htmlspecialchars($error); ?></li>
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


</html>