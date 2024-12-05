<?php
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/src/' . $class_name . '.php';
});
session_start();
$db = new Database();
$user = new User();
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = 'You need to login first';
    header('Location: login.php');
    exit;
}
unset($_SESSION['user']);
unset($_SESSION['success']);
unset($_SESSION['error']);
$_SESSION['success'] = 'You are now logged out';
header('Location: index.php');
exit;
?>