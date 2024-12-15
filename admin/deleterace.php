<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../src/' . $class_name . '.php';
});
session_start();
$db = new Database();
$admin = new Admin();
$races = new Race();
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
$current = $_GET['n'] ?? null;
$race_id = $_GET['id'] ?? null;
$race = $races->getRaceById($race_id) ?? null;
if (!$race) {
    header('Location: racelist.php');
    $_SESSION['error'] = 'Race not found';
    exit;
} else {
    $races->deleteRace($race_id);
    $_SESSION['success'] = 'Deleted successfully';
    header('Location: ' . $current);
    exit;
}
?>