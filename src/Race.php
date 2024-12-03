<?php
spl_autoload_register(function ($class) {
    require_once __DIR__ . '/' . $class . '.php';
});

$db = new Database();
class Race {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function validateRaceData($data) {
        $requiredFields = ['fullName', 'nationality', 'gender', 'age', 'passportNo', 'address', 'mobilePhone', 'hotelName'];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[] = "$field is required.";
            }
        }
        if (!empty($errors)) {
            return $errors;
        }
        if (!is_numeric($data['age']) || $data['age'] <= 0 || $data['age'] > 80) {
            $errors[] = "Age must be a number between 1 and 80.";
        }

        if (!preg_match("/^[0-9]{9}$/", $data['passportNo'])) {
            $errors[] = "Passport number must be a 9-digit number.";
        }

        if (!preg_match("/^[0-9]{10}$/", $data['mobilePhone'])) {
            $errors[] = "Mobile phone must be a 10-digit number.";
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

    public function editRace($index, $newRaceName, $newRaceDate) {
        $query = "UPDATE races SET name = :name, date = :date WHERE id = :id";
        $params = [
            ':name' => $newRaceName,
            ':date' => $newRaceDate,
            ':id' => $index
        ];
        $this->db->execute($query, $params);
        return "Race updated successfully.";
    }

    public function getRaces() {
        $query = "SELECT * FROM races";
        return $this->db->query($query);
    }
}

?>