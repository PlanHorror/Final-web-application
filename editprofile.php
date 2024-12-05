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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $user->update($_POST);
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
$countryList = file_get_contents('https://api.first.org/data/v1/countries');
$countries = json_decode($countryList, true)['data'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
    <style>
        body {
            background-image: url('media/background.jpg');
        }
        
        .edit-form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 20px;
            margin-top: 150px;
        }
        .lbg {
            border-radius: 20px;

        }

        .form-label {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .btn {
            font-size: 1.2rem;
        }
        .non-auth {
            display: none;
        }
        .error-login {
            color: red;
            font-size: 90%;
        }
    </style>
</head>
<body>
    <?php include 'template/navbar.html'; ?>
    <?php include 'template/message.php'; ?>
    <div class="container edit-form-container">
        <div class=" form col-md-12 d-flex">
            <div class="bg-light p-5 w-100 h-100 lbg">
            
            <form action="editprofile.php" method="POST">
                <h2 class="text-center mb-5">Edit Profile</h2>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user_info['id']); ?>">
                <!-- Full Name -->
                <div class="mb-4">
                    <label for="full_name" class="form-label">Full Name:</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user_info['name']); ?>" required>
                </div>
                <!-- Age -->
                <div class="mb-4">
                    <label for="age" class="form-label">Age:</label>
                    <input type="number" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($user_info['age']); ?>" required>
                </div>
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_info['email']); ?>" required>
                </div>

                <!-- Nationality -->
                <div class="mb-4">
                    <label for="nationality" class="form-label">Nationality:</label>
                    <select class="form-control" id="nationality" name="nationality" required style="font-size: 1.5rem;">
                        <option value="<?php echo htmlspecialchars($user_info['nationality']); ?>"  selected><?php echo htmlspecialchars($user_info['nationality']); ?></option>
                        <!-- API will populate this dropdown -->
                        <?php foreach ($countries as $key => $value): ?>
                            <?php if ($value['country'] == $user_info['nationality']) continue; ?>
                            <option value="<?php echo htmlspecialchars($value['country']); ?>"><?php echo htmlspecialchars($value['country']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Gender -->
                <div class="mb-4">
                    <label for="gender" class="form-label">Gender:</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="Male" <?php if ($user_info['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($user_info['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if ($user_info['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>

                <!-- Passport Number -->
                <div class="mb-4">
                    <label for="passport_no" class="form-label">Passport No:</label>
                    <input type="text" class="form-control" id="passport_no" name="passport_no" value="<?php echo htmlspecialchars($user_info['passport_no']); ?>">
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="form-label">Address:</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($user_info['address']); ?></textarea>
                </div>
                <!-- Phone Number -->
                <div class="mb-4">
                    <label for="phone_number" class="form-label">Phone Number:</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user_info['phone_number']); ?>" required>
                </div>
                <!-- Current Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">Current Password:</label>
                    <input type="password" class="form-control" id="password" name="password" >
                </div>

                <!-- New Password -->
                <div class="mb-4">
                    <label for="password1" class="form-label">New Password:</label>
                    <input type="password" class="form-control" id="password1" name="password1" >
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password2" class="form-label">Confirm New Password:</label>
                    <input type="password" class="form-control" id="password2" name="password2" >
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                </div>

                <!-- Back to profile -->
                <div class="text-center mt-3">
                    <a href="profile.php" class="btn btn-secondary w-100">Back to Profile</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
