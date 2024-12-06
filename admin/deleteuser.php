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
$user_id = $_GET['id'] ?? null;
$user = $admin->getAdminById($user_id) ?? null;
if (!$user) {
    header('Location: userlist.php');
    $_SESSION['error'] = 'User not found';
    exit;
} else {
    $admin->deleteUser($user_id);
    $_SESSION['success'] = 'Deleted successfully';
    header('Location: userlist.php');
    exit;
}
?>