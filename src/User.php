<?php

class User {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function validateRegister($data) {
        $errors = [];
        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        } else {
            if (!preg_match('/^[a-zA-Z0-9]+$/', $data['username'])) {
                $errors['username'] = 'Username can only contain letters and numbers';
            }
            if (strlen($data['username']) > 20) {
                $errors['username'] = 'Username must be less than 20 characters';
            }
            if (strlen($data['username']) < 3) {
                $errors['username'] = 'Username must be more than 3 characters';
            }
            if ($this->db->getUser(['username' => $data['username']])) {
                $errors['username'] = 'Username already exists';
            }
        }
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } else {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email must be a valid email address';
            }
            if ($this->db->getUser(['email' => $data['email']])) {
                $errors['email'] = 'Email already exists';
            }
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } else {
            if (strlen($data['password']) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            }
            if ($data['password'] !== $data['confirm_password']) {
                $errors['password'] = 'Passwords do not match';
            }
        }
        return $errors;
    }
    public function validateLogin($data) {
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
        }

        return $errors;
    }
    public function register($data) {
        $this->validateRegister($data);
        if (count($this->validateRegister($data)) > 0) {
            return ['errors' => $this->validateRegister($data)];
        }
        $this->db->create(['username' => $data['username'], 'email' => $data['email'], 'password' => password_hash($data['password'], PASSWORD_DEFAULT)], 'users');
        
        return;
    }
    public function login($data) {
        $this->validateLogin($data);
        if (count($this->validateLogin($data)) > 0) {
            return ['errors' => $this->validateLogin($data)];
        }
        
        return;
    }
    public function logout() {
        session_destroy();
        header('Location: login.php');
    }
    public function getUserByName($username) {
        $user = $this->db->getUser(['username' => $username]);
        return ['id' => $user['id'], 'username' => $user['username'], 'email' => $user['email'], 'admin' => $user['admin']];
    }
    public function getUserById($id) {
        return $this->db->readById($id, 'users');
    }
    public function getUserAchievements($id) {
        return $this->db->readById($id, 'race_bib');
    }
}

?>