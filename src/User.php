<?php

class User {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function validateRegister($data) {
        $errors = [];
        // Validate full name
        if (!preg_match('/^[a-zA-Z\s]+$/', $data['full_name'])) {
            $errors[] = 'Username must only contain letters and spaces';
        }
        // Validate age
        if (!number_format($data['age'])) {
            $errors[] = 'Age must be a number';
        }
        if ($data['age'] < 18 || $data['age'] > 80) {
            $errors[] = 'You must be between 18 and 80 years old to register';
        }
        // Validate passport number
        if (!empty($data['passport_no']) && !preg_match('/^[A-Z0-9]{6,9}$/', $data['passport_no'])) {
            $errors[] = 'Passport number must be 6-9 characters long and contain only uppercase letters and numbers';
        }
        // Validate phone number
        if (!preg_match('/^\+?[0-9]{10,14}$/', $data['phone_number'])) {
            $errors[] = 'Phone number must be between 10 and 14 digits long and contain only numbers';
        }
        if ($this->db->getUser(['phone_number' => $data['phone_number']])) {
            $errors[] = 'Phone number already exists';
        }
        // Validate email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email must be a valid email address';
        }
        if ($this->db->getUser(['email' => $data['email']])) {
            $errors[] = 'Email already exists';
        }
        // Validate password
        if (strlen($data['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'Passwords do not match';
        }
        
        return $errors;
    }
    public function validateLogin($data) {
        $errors = [];
        if (!empty($data['email'] && !empty($data['password']))) {
            $user = $this->db->getUser(['email' => $data['email']]);
            if ($user) {
                if (password_verify($data['password'], $user['password'])) {
                    $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'admin' => $user['admin']];
                    $_SESSION['success'] = 'You are now logged in';
                    header('Location: index.php');
                } else {
                    $errors[] = 'Incorrect email or password';
                }
            } else {
                $errors[] = 'Incorrect email or password';
            }
        }

        return $errors;
    }
    public function validateUpdate($data){
        $errors = [];
        // Validate full name
        if (!preg_match('/^[a-zA-Z\s]+$/', $data['full_name'])) {
            $errors[] = 'Username must only contain letters and spaces';
        }
        // Validate age
        if (!number_format($data['age'])) {
            $errors[] = 'Age must be a number';
        }
        if ($data['age'] < 18 || $data['age'] > 80) {
            $errors[] = 'You must be between 18 and 80 years old';
        }
        // Validate passport number
        if (!empty($data['passport_no']) && !preg_match('/^(?!^0+$)[a-zA-Z0-9]{3,20}$/', $data['passport_no'])) {
            $errors[] = 'Passport number must be between 3 and 20 characters long and contain only letters and numbers';
        }
        // Validate phone number
        if (!preg_match('/^\+?[0-9]{10,14}$/', $data['phone_number'])) {
            $errors[] = 'Phone number must be between 10 and 14 digits long and contain only numbers';
        }
        $user = $this->db->getUser(['phone_number' => $data['phone_number']]);
        if ($user && $user['id'] != $data['id']) {
            $errors[] = 'Phone number already exists';
        }
        if (empty($data['email'])) {
            $errors[] = 'Email is required';
        } else {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email must be a valid email address';
            }
            $user = $this->db->getUser(['email' => $data['email']]);
            if ($user && $user['id'] != $data['id']) {
                $errors[] = 'Email already exists';
            }
        }
        if (!empty($data['password'])) {
            $user = $this->db->readById($data['id'], 'users');
            if (!password_verify($data['password'], $user['password'])) {
                $errors[] = 'Incorrect password';
            }
            if (strlen($data['password1']) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }
            if ($data['password1'] !== $data['password2']) {
                $errors[] = 'Passwords do not match';
            }
        }
        return $errors;
    }
    public function register($data) {
        $this->validateRegister($data);
        if (count($this->validateRegister($data)) > 0) {
            return ['errors' => $this->validateRegister($data)];
        }
        $data['passport_no'] ? $this->db->create([
            'name' => $data['full_name'],
            'age' => $data['age'],
            'nationality' => $data['nationality'],
            'gender' => $data['gender'],
            'passport_no'=> $data['passport_no'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ], 'users') : $this->db->create([
            'name' => $data['full_name'],
            'age' => $data['age'],
            'nationality' => $data['nationality'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ], 'users');
        $_SESSION['success'] = 'You are now registered and can log in';
        header('Location: login.php');
        return;
    }
    public function login($data) {
        $this->validateLogin($data);
        if (count($this->validateLogin($data)) > 0) {
            return ['errors' => $this->validateLogin($data)];
        }
        
        return;
    }
    public function update($data) {
        var_dump($data);
        $this->validateUpdate($data);
        if (count($this->validateUpdate($data)) > 0) {
            return ['errors' => $this->validateUpdate($data)];
        }
        $user = $this->db->readById($data['id'], 'users');
        $data['passport_no'] ? $this->db->update([
            'id' => $data['id'],
            'name' => $data['full_name'],
            'age' => $data['age'],
            'nationality' => $data['nationality'],
            'gender' => $data['gender'],
            'passport_no'=> $data['passport_no'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => !empty($data['password1']) ? password_hash($data['password1'], PASSWORD_DEFAULT) : $user['password']
        ], 'users') : $this->db->update([
            'id' => $data['id'],
            'name' => $data['full_name'],
            'age' => $data['age'],
            'nationality' => $data['nationality'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => !empty($data['password1']) ? password_hash($data['password1'], PASSWORD_DEFAULT) : $user['password']
        ], 'users');
        $_SESSION['success'] = 'Profile updated successfully';
        header('Location: profile.php');
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
        $sql = 'SELECT * from (SELECT * FROM register_form WHERE user_id =' . $id . ') as reg LEFT JOIN (SELECT * FROM race) as r ON r.id = reg.race_id';
        return $this->db->query($sql);
    }
}

?>