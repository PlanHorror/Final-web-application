<?php
session_start();
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../src/' . $class_name . '.php';
});
$db = new Database();
$race = new Race();
$admin = new Admin();
$users = new User();
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
$races = $race->getParticipants();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $race->updateTimeRecord($_POST);
    $users->updateBestRecord();
    $_SESSION['success'] = 'Record updated successfully';
    header('Location: participantlist.php');
    exit;
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
    <title>User Registrations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url('../media/background.jpg');
        }
        h1 {
            font-size: 2.5rem;
            color: #fff;
        }
        .main {
            padding: 20px;
        }
        .banner {
            height: 20vh;
        }
        .list-course {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
        }
        .non-auth {
            display: none;
        }
        .extended-time-input {
      border: 2px solid #4CAF50;
      border-radius: 5px;
      padding: 10px;
      font-size: 16px;
      outline: none;
      width: 100%;
    }
    </style>
</head>
<body>
<?php include '../template/admin-navbar.html'; ?>
<?php include '../template/message.php'; ?>

    <div class="container-fluid banner"></div>  
    <div class="container mt-4 main">
        <div class="row">
            <div class="col-12 mb-4">
                <h1>Registered Users</h1>
            </div>
        </div>

        <!-- Race Registration Dropdowns -->
       
        <div class="accordion"id="raceAccordion">
            <?php foreach ($races as $race) : ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?php echo$race['id']?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo$race['id']?>" aria-expanded="false" aria-controls="collapse_<?php echo$race['id']?>">
                        <?php echo $race['race_name']; ?>
                    </button>
                </h2>
                <div id="collapse_<?php echo$race['id']?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo$race['id']?>" data-bs-parent="#raceAccordion">
                    <div class="accordion-body">
                        <form action="participantlist.php" method="post">
                        <input type="hidden" name="race_id" value="<?php echo $race['id']; ?>">
                        <table class="table table-bordered"  style="width: 100%; table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th style="width: 11%;">Entry Number</th>
                                    <th style="width: 10%;">Name</th>
                                    <th style="width: 9%;">Nationality</th>
                                    <th style="width: 7%;">Gender</th>
                                    <th style="width: 5%;">Age</th>
                                    <!-- <th style="width: 10%;">Mobile Phone</th> -->
                                    <th style="width: 21%;">Email</th>
                                    <th style="width: 6%;">Hotel Name</th>
                                    <th style="width: 15%;">Record</th>
                                    <th style="width: 8%;">Standing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!isset($race['total'])) : ?>
                                <?php foreach ($race['participants'] as $participant) : ?>
                                <tr>
                                    
                                    <td><?php echo $participant['entry_number']; ?></td>
                                    <td><?php echo $participant['name']; ?></td>
                                    <td><?php echo $participant['nationality']; ?></td>
                                    <td><?php echo $participant['gender']; ?></td>
                                    <td><?php echo $participant['age']; ?></td>
                                    
                                    <td><?php echo $participant['email']; ?></td>
                                    <td><?php echo $participant['hotel_name']?$participant['hotel_name']: 'N/A'; ?></td>
                                    <td><input 
                                    id="extended-time" 
                                    type="text" 
                                    class="extended-time-input" 
                                    placeholder="HH:MM:SS" 
                                    name="<?php echo $participant['id']?>" 
                                    value="<?php echo $participant['time_record']?>"
                                    style="width: 100%;"
                                    ></td>
                                    <td><?php echo $participant['standings']?$participant['standings']: 'N/A'; ?></td>
                                    
                                </tr>
                                <?php endforeach; ?>
                                <?php else : ?>
                                <tr>
                                    <td colspan="12" style="text-align:center">No participants yet</td>
                                </tr>
                                <?php endif; ?>
                        </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary" style="width:100%">Update Record</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        
                    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const timeInputs = document.querySelectorAll(".extended-time-input");

        timeInputs.forEach((input) => {
            // Auto-format input to HH:MM:SS
            input.addEventListener("input", (e) => {
                let value = e.target.value;

                // Remove invalid characters
                value = value.replace(/[^0-9:]/g, '');

                // Auto-add colons to format input as HH:MM:SS
                if (value.length > 2 && value[2] !== ":") {
                    value = value.slice(0, 2) + ":" + value.slice(2);
                }
                if (value.length > 5 && value[5] !== ":") {
                    value = value.slice(0, 5) + ":" + value.slice(5);
                }
                if (value.length > 8) {
                    value = value.slice(0, 8); // Max length is HH:MM:SS
                }
                // Dont allow more than 60 minutes or seconds
                if (value[3] > 5) {
                    value = value.slice(0, 3) + "5" + value.slice(4);
                }
                if (value[6] > 5) {
                    value = value.slice(0, 6) + "5" + value.slice(7);
                }
                e.target.value = value;
            });

            // Validate time format on blur
            input.addEventListener("blur", (e) => {
                const value = e.target.value;
                const timeRegex = /^([0-9][0-9]):([0-5][0-9]):([0-5][0-9])$/;

                if (!timeRegex.test(value)) {
                    
                    e.target.value = ""; // Clear input on invalid format
                }
            });
        });
    });
</script>


</body>
</html>
hotel_name