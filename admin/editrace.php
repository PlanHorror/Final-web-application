<?php
session_start();
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../src/' . $class_name . '.php';
});
$db = new Database();
$race = new Race();
$admin = new Admin();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    $_SESSION['error'] = 'You must be logged in to access this page';
    exit;
} else {
    $user = $admin->getAdminById($_SESSION['user']['id']);
    if (!$user['admin']) {
        header('Location: login.php');
        $_SESSION['error'] = 'You must be an admin to access this page';
        exit;
    }
}
// Get race id from URL
$race_id = $_GET['id'] ?? null;
$race_info = $race->getRaceById($race_id) ?? null;
if (!$race_id || !$race_info) {
    header('Location: racelist.php');
    $_SESSION['error'] = 'Race not found';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    var_dump($_FILES);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Race</title>
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
<?php //include '../template/admin-navbar.html'; ?>
<?php include '../template/message.php'; ?>

<div class="container form-create-race">
    <div class="form-container">
        <h1>Edit Race</h1>
        <form id="raceForm" method="POST" enctype="multipart/form-data" action="editrace.php?id=<?php echo $race_info['id']?>">
            <!-- Race Name -->
            <div class="mb-3">
                <label for="race_name" class="form-label">Race Name</label>
                <input type="text" class="form-control" id="race_name" name="race_name" 
                       value="<?php echo htmlspecialchars($race_info['race_name']); ?>" required>
            </div>

            <!-- Entry Prefix -->
            <div class="mb-3">
                <label for="entry_prefix" class="form-label">Entry Prefix</label>
                <input type="text" class="form-control" id="entry_prefix" name="entry_prefix" 
                       value="<?php echo htmlspecialchars($race_info['entry_prefix']); ?>" required>
            </div>

            <!-- Race Start DateTime -->
            <div class="mb-3">
                <label for="race_start" class="form-label">Race Start</label>
                <input type="datetime-local" class="form-control" id="race_start" name="race_start" 
                       value="<?php echo date('Y-m-d\TH:i', strtotime($race_info['race_start'])); ?>" required>
            </div>

            <div class="dynamic-section" id="dynamicFields">
                <h5>Additional Details</h5>
                <?php foreach ($race_info['images'] as $index => $image): ?>
                <div class="mb-3" id="imageField_<?php echo $index + 1; ?>" data-field-id="<?php echo $index + 1; ?>">
                    <label for="image_<?php echo $index + 1; ?>" class="form-label">Image <?php echo $index + 1; ?></label>
                    <input type="file" class="form-control" id="image_<?php echo $index + 1; ?>" 
                        name="image_<?php echo $index + 1; ?>" accept="image/*" value="<?php echo $image['url']; ?>" required>
                    <p>Current: <img src="<?php echo $image['url']; ?>" alt="image_<?php echo $index + 1; ?>" 
                                    style="width: 100px; height: auto;"></p>

                    <label for="description_<?php echo $index + 1; ?>" class="form-label mt-3 form-des">Description <?php echo $index + 1; ?></label>
                    <textarea class="form-control" id="description_<?php echo $index + 1; ?>" 
                            name="description_<?php echo $index + 1; ?>" rows="3" required><?php echo htmlspecialchars($image['description']); ?></textarea>


                    <!-- Delete button -->
                    <button type="button" class="btn btn-danger btn-sm mt-2 delete-image-btn" id="delete_image_<?php echo $index + 1; ?>" data-field-id="<?php echo $index + 1; ?>">Delete</button>
                </div>
                <?php endforeach; ?>
            </div>



            <!-- Buttons -->
            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-add" id="addField">Add Image & Description</button>
                <button type="button" class="btn btn-remove " id="removeField">Remove Last</button>
            </div>

            <input type="hidden" name="race_id" value="<?php echo htmlspecialchars($race_info['id']); ?>">


            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Update Race</button>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const addFieldButton = document.getElementById("addField");
        const removeFieldButton = document.getElementById("removeField");
        const currentStateRemove = document.querySelectorAll('.delete-image-btn');
        const countFields = () => document.querySelectorAll('.dynamic-section > div').length;
        const changeState = () => {
            let dynamicFieldss = document.getElementById("dynamicFields");
            let index = 1;
            dynamicFieldss.querySelectorAll('.dynamic-section > div').forEach((field) => {
                // Set name labels and ids
                field.querySelector('.form-label').textContent = `Image ${index}`;
                field.querySelector('.form-des').textContent = `Description ${index}`; 
                field.setAttribute('data-field-id', index);
                field.id = `imageField_${index}`;
                field.querySelector('label[for^="image_"]').setAttribute('for', `image_${index}`);
                field.querySelector('input[name^="image_"]').name = `image_${index}`;
                field.querySelector('textarea[name^="description_"]').name = `description_${index}`;
                field.querySelector('label[for^="description_"]').setAttribute('for', `description_${index}`);
                field.querySelector('.delete-image-btn') ? field.querySelector('.delete-image-btn').id = `delete_image_${index}` : null;
                field.querySelector('.delete-image-btn') ? field.querySelector('.delete-image-btn').setAttribute('data-field-id', index) : null;
                index++;
            });
        };
        addFieldButton.addEventListener("click", function () {
            const dynamicFields = document.getElementById("dynamicFields");
            const fieldCount = countFields() + 1;
            const fieldGroup = document.createElement("div");
            fieldGroup.classList.add("mb-3");
            fieldGroup.setAttribute("data-field-id", fieldCount);
            fieldGroup.id = `imageField_${fieldCount}`;
            fieldGroup.innerHTML = `
                <label for="image_${fieldCount}" class="form-label">Image ${fieldCount}</label>
                <input type="file" class="form-control" id="image_${fieldCount}" name="image_${fieldCount}" accept="image/*" required>
                <label for="description_${fieldCount}" class="form-label mt-3 form-des">Description ${fieldCount}</label>
                <textarea class="form-control" id="description_${fieldCount}" name="description_${fieldCount}" rows="3" required></textarea>
                <input type="hidden" name="delete_image_${fieldCount}" id="delete_image_${fieldCount}" value="0">
            `;
            dynamicFields.appendChild(fieldGroup);
            changeState();
        });
        removeFieldButton.addEventListener("click", function () {
            const dynamicFields = document.getElementById("dynamicFields");
            if (countFields() > 0) {
                dynamicFields.removeChild(dynamicFields.lastChild);
                changeState();
            }
        });
        currentStateRemove.forEach((button) => {
            
            button.addEventListener('click', function () {
                $id = button.getAttribute('data-field-id');
                const dynamicFields = document.getElementById("dynamicFields");
                dynamicFields.removeChild(document.getElementById(`imageField_${button.getAttribute('data-field-id')}`));
                changeState();
            });
        });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
