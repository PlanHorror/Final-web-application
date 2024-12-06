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
        if (!empty($data['email']) && !empty($data['password'])) {
            $user = $this->db->getUser(['email' => $data['email']]);
            if (!$user || !password_verify($data['password'], $user['password'])) {
                $errors[] = 'Invalid email or password';
            }
            if ($user['admin'] === 0) {
                $errors[] = 'You must be an admin to access this page';
            }
        } else {
            $errors[] = 'Email and password are required';
        }

        return $errors;
        
    }
    private function validateUpdate($data) {
        $errors = [];
        $pw = 0;
        if (!empty($data['full_name']) && !empty($data['email']) && !empty($data['age']) && !empty($data['nationality']) && !empty($data['gender']) && !empty($data['address']) && !empty($data['phone_number'])) {
            // Validate full name
            if (!preg_match("/^[a-zA-Z-' ]*$/", $data['full_name'])) {
                $errors[] = 'Only letters and white space allowed';
            }
            // Validate email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            }
            $user = $this->db->getUser(['email' => $data['email']]);
            if ($user && $user['id'] != $data['id']) {
                $errors[] = 'Email already exists';
            }
            // Validate passport number
            if (!empty($data['passport_no']) && !preg_match('/^(?!^0+$)[a-zA-Z0-9]{3,20}$/', $data['passport_no'])) {
                $errors[] = 'Passport number must be between 3 and 20 characters long and contain only letters and numbers';
            }
            // Validate age
            if (!is_numeric($data['age'])) {
                $errors[] = 'Age must be a number';
            }
            if ($data['age'] < 18 || $data['age'] > 80) {
                $errors[] = 'Age must be between 18 and 80';
            }
            // Validate phone number
            if (!preg_match('/^\+?[0-9]{10,14}$/', $data['phone_number'])) {
                $errors[] = 'Phone number must be between 10 and 14 digits long and contain only numbers';
            }
            $user = $this->db->getUser(['phone_number' => $data['phone_number']]);
            if ($user && $user['id'] != $data['id']) {
                $errors[] = 'Phone number already exists';
            }
            // Validate password
            if (!empty($data['password'])){
                $user = $this->db->getUser(['id' => $data['id']]);
                if (password_verify($data['password'], $user['password'])) {
                    $pw = 1;
                } else {
                    $errors[] = 'Incorrect old password';
                }
                if (strlen($data['password1']) < 6) {
                    $errors[] = 'Password must be at least 6 characters';
                }
                if ($data['password1'] !== $data['password2']) {
                    $errors[] = 'Passwords do not match';
                }
            }
        } else {
            $errors[] = 'All fields are required';
        } 
        return ['errors' => $errors, 'pw' => $pw];
    }
    public function validateRaceInfo($data) {
        $errors = [];
        if (!empty($data['race_name']) && !empty($data['race_start']) && !empty($data['create_by_id'])) {
            // Validate race_start
            $race_start = date('Y-m-d', strtotime($data['race_start']));
            if ($race_start <= date('Y-m-d')) {
                $errors[] = 'Race start date must be in the future';
            }
        } else {
            $errors[] = 'All fields are required';
        }
        return $errors; 
    }
    public function validateRaceImage($files) {
        $errors = [];
        foreach ($files as $file) {
            // $errors[] = $file['name'];
            if ($file['size'] > 1000000) {
                // $errors[] = 'File size must be less than 1MB' . ' ' . $file['name'] . ' ' . $file['size'];
                
            }
            $file_type = pathinfo($file['name'], PATHINFO_EXTENSION);
            if (!in_array($file_type, ['jpg', 'jpeg', 'png'])) {
                $errors[] = 'File must be a jpg, jpeg, or png';
                break;
            }
        }
        return $errors;
    }
    public function getAdminById($id) {
        return $this->db->readById($id, 'users');
    }
    public function getAdminByEmail($email) {
        $user = $this->db->getUser(['email' => $email]);
        return ['id' => $user['id'], 'email' => $user['email'], 'admin' => $user['admin']];
    }
    public function getAllUsers() {
        return $this->db->readAll('users');
    }
    public function updateProfile($data) {
        $validate = $this->validateUpdate($data);
        if (!empty($validate['errors'])) {
            return $validate['errors'];
        }
        if (!empty($data['passport_no'])) {
            $data = [
                'id' => $data['id'],
                'name' => $data['full_name'],
                'email' => $data['email'],
                'age' => $data['age'],
                'nationality' => $data['nationality'],
                'gender' => $data['gender'],
                'passport_no' => $data['passport_no'],
                'address' => $data['address'],
                'phone_number' => $data['phone_number']
            ];
        } else {
            $data = [
                'id' => $data['id'],
                'name' => $data['full_name'],
                'email' => $data['email'],
                'age' => $data['age'],
                'nationality' => $data['nationality'],
                'gender' => $data['gender'],
                'address' => $data['address'],
                'phone_number' => $data['phone_number']
            ];
        }
        if ($validate['pw'] === 1) {
            $data['password'] = password_hash($data['password1'], PASSWORD_DEFAULT);
        }
        $this->db->update($data, 'users');
        return;
    }
    public function deleteUser($id) {
        $this->db->delete($id, 'users');
        return ;
    }
    public function createRace($data, $files) {
        $errors = $this->validateRaceInfo($data);
        $errors = array_merge($errors, $this->validateRaceImage($files));
        if (!empty($errors)) {
            return ['errors' => $errors];
        } else {
            $this->db->create([
                'race_name' => $data['race_name'],
                'entry_prefix' => $data['entry_prefix'],
                'race_start' => $data['race_start'],
                'create_by_id' => $data['create_by_id'],
            ], 'race');
            $race_id = $this->db->readLastId();
            try {
                $total_files = count($files);
                for ($i = 1; $i < $total_files + 1; $i++) {
                    $name = $files['image_' . $i]['name'];
                    $description = $data['description_' . $i];
                    $path = '../media/race_image/' . 'image_' . $i . 'race_' . $race_id . '_' . $name;
                    move_uploaded_file($files['image_' . $i]['tmp_name'], $path);
                    $this->db->create([
                        'url' => $path,
                        'description' => $description,
                        'race_id' => $race_id,
                    ], 'gallery');
                }
                    
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
                return ['errors' => $errors];
            }
            
        }
    }
        
}

?>