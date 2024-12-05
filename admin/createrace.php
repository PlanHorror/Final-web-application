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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $admin->createRace($_POST, $_FILES);
    if (empty($res['errors'])) {
        $_SESSION['success']='Race created successfully!';
        header('Location: index.php');
        exit;
    } else {
        $errors = $res['errors'];
    }
}
$successMessage = $_SESSION["success"] ?? null;
unset($_SESSION['success']);
$errorMessage = $_SESSION["error"] ?? null;
unset($_SESSION['error']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Race</title>
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
        .banner {
            height: 20vh;
        }
        .form-create-race {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 20px;
            margin-top: 150px;

        }
        .form-container {
            
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2rem;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .dynamic-section {
            margin-top: 20px;
        }
        .btn-add {
            background-color: #28a745;
            color: #fff;
        }
        .btn-add:hover {
            background-color: #218838;
        }
        .btn-remove {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-remove:hover {
            background-color: #c82333;
        }
        .non-auth {
        display: none;
        }   
        .error-login {
            color: red;
            font-size: 90%;
            height: 15%;
        }
    </style>
</head>
<body>
<?php include '../template/admin-navbar.html'; ?>
<?php include '../template/message.php'; ?>
    <div class="container form-create-race">
        <div class="form-container ">
            <h1>Create Race</h1>
            <form id="raceForm h-100 w-100" method="POST" enctype="multipart/form-data">
                <!-- Race Name -->
                <div class="mb-3">
                    <label for="race_name" class="form-label">Race Name</label>
                    <input type="text" class="form-control" id="race_name" name="race_name" required>
                </div>
                
                <!-- Entry prefix -->
                <div class="mb-3">
                    <label for="entry_prefix" class="form-label">Entry Prefix</label>
                    <input type="text" class="form-control" id="entry_prefix" name="entry_prefix" required>
                </div>

                <!-- Race Start DateTime -->
                <div class="mb-3">
                    <label for="race_start" class="form-label">Race Start</label>
                    <input type="datetime-local" class="form-control" id="race_start" name="race_start" required>
                </div>

                <!-- Dynamic Section -->
                <div class="dynamic-section" id="dynamicFields">
                    <h5>Additional Details</h5>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-add" id="addField">Add Image & Description</button>
                    <button type="button" class="btn btn-remove d-none" id="removeField">Remove Last</button>
                </div>
                <input type="hidden" name="create_by_id" value="<?php echo htmlspecialchars($user_info['id']); ?>">
                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Create Race</button>
                </div>
                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li class="error-login"><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach;?>
                    </ul>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dynamicFields = document.getElementById("dynamicFields");
            const addFieldButton = document.getElementById("addField");
            const removeFieldButton = document.getElementById("removeField");

            let fieldCount = 0;

            // Add new fields
            addFieldButton.addEventListener("click", function() {
                fieldCount++;

                const fieldGroup = document.createElement("div");
                fieldGroup.classList.add("mb-3");
                fieldGroup.setAttribute("data-field-id", fieldCount);
                fieldGroup.innerHTML = `
                    <label for="image_${fieldCount}" class="form-label">Image ${fieldCount}</label>
                    <input type="file" class="form-control" id="image_${fieldCount}" name="image_${fieldCount}" accept="image/*" required>

                    <label for="description_${fieldCount}" class="form-label mt-3">Description ${fieldCount}</label>
                    <textarea class="form-control" id="description_${fieldCount}" name="description_${fieldCount}" rows="3" required></textarea>
                `;

                dynamicFields.appendChild(fieldGroup);

                // Show remove button
                removeFieldButton.classList.remove("d-none");
            });

            // Remove last added fields
            removeFieldButton.addEventListener("click", function() {
                if (dynamicFields.lastChild) {
                    dynamicFields.removeChild(dynamicFields.lastChild);
                    fieldCount--;

                    // Hide remove button if no fields remain
                    if (fieldCount === 0) {
                        removeFieldButton.classList.add("d-none");
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

