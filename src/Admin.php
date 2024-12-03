<?php

spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../src/' . $class_name . '.php';
});

class Admin {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($data) {
        $errors = $this->validateLogin($data);
        if (!empty($errors)) {
            return ['errors' => $errors];
        }
        return;
    }

    private function validateLogin($data) {
        // Assuming the Database class has a method to validate user credentials
        $errors = [];
        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        }
        if (!empty($data['username']) && !empty($data['password'])) {
            $user = $this->db->getUser(['username' => $data['username']]);
            if (!$user || !password_verify($data['password'], $user['password'])) {
                $errors['login'] = 'Username or password is incorrect';
            }
            if ($user['admin'] === 0) {
                $errors['admin'] = 'You must be an admin to access this page';
            }
        }

        return $errors;
        
    }
    private function validateUpdate($data) {
        $errors = [];
        $pw = 0;
        if (empty($data['username'])) {
            $errors[] = 'Username is required';
        }
        
        if (empty($data['email'])) {
            $errors[] = 'Email is required';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is invalid';
        }
        $thisuser = $this->db->readById($data['id'], 'users');
        $duplicatename = $this->db->getUser(['username' => $data['username']]);
        $duplicateemail = $this->db->getUser(['email' => $data['email']]);
        if ($duplicatename && $duplicatename['username'] !== $thisuser['username']) {
            $errors[] = 'Username is already taken';
        }
        if ($duplicateemail && $duplicateemail['email'] !== $thisuser['email']) {
            $errors[] = 'Email is already taken';
        }
        if (!empty($data['password'])){
            $pw = 1;
            // Check old password
            $user = $this->db->getUser(['username' => $data['username']]);
            if (!password_verify($data['password'], $user['password'])) {
                $errors[] = 'Old password is incorrect';
            }
            if (strlen($data['password1']) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }
            if ($data['password1'] !== $data['password2']) {
                $errors[] = 'Passwords do not match';
            }
        }
        // $errors[] = 'Profile updated successfully';
        return ['errors' => $errors, 'pw' => $pw];
    }
    public function getAdminById($id) {
        return $this->db->readById($id, 'users');
    }
    public function getAdminByName($username) {
        $user = $this->db->getUser(['username' => $username]);
        return ['id' => $user['id'], 'username' => $user['username'], 'email' => $user['email'], 'admin' => $user['admin']];
    }
    public function getAllUsers() {
        return $this->db->readAll('users');
    }
    public function updateProfile($data) {
        $validate = $this->validateUpdate($data);
        if (!empty($validate['errors'])) {
            return $validate['errors'];
        }
        if ($validate['pw'] === 1) {
            $data = ['id' => $data['id'], 'username' => $data['username'], 'email' => $data['email'], 'password' => password_hash($data['password1'], PASSWORD_DEFAULT)];
        } else {
            $data = ['id' => $data['id'], 'username' => $data['username'], 'email' => $data['email']];
        }
        $this->db->update($data, 'users');
        return;
    }
    public function deleteUser($id) {
        $this->db->delete($id, 'users');
        return "User deleted successfully.";
    }
}

?>