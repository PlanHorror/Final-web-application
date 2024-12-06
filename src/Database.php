<?php
class Database {
    private $host = 'localhost';
    private $db_name = '22110173';
    private $username = 'root';
    private $password = '';
    private $conn;
    // Constructor
    public function __construct() {
        $this->connect();
    }
    // Connect to the database
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
    public function create($data, $table) {
        $keys = array_keys($data);
        $values = array_values($data);
        $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES (:' . implode(', :', $keys) . ')';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }
    public function read($table) {
        $sql = 'SELECT * FROM ' . $table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function readById($id, $table) {
        $sql = 'SELECT * FROM ' . $table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function readLastId() {
        return $this->conn->lastInsertId();
    }
    public function readByColumn($column, $value, $table) {
        $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$value]); 
        return $stmt->fetchAll();
    }
    public function query($sql) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function readAll($table) {
        $sql = 'SELECT * FROM ' . $table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function update($data, $table) {
        $id = $data['id'];
        $keys = array_keys($data);
        $values = array_values($data);
        $sql = 'UPDATE ' . $table . ' SET ';
        foreach ($keys as $key) {
            if ($key !== 'id') {
                $sql .= $key . ' = :' . $key . ', ';
            }
        }
        $sql = rtrim($sql, ', ');
        $sql .= ' WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);

    }
    public function delete($id, $table) {
        $sql = 'DELETE FROM ' . $table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function deleteByField($column ,$value ,$table){
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $column . ' = ' . $value;
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
    public function addUser($username, $email, $password) {
        $sql = 'INSERT INTO users (username, email, password, admin) VALUES (:username, :email, :password, 0)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
    }
    public function getUser($data) {
       if (array_key_exists('email', $data)) {
        
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $data['email']]);
            return $stmt->fetch();
        } else if (array_key_exists('username', $data)) {
            $sql = 'SELECT * FROM users WHERE name = :username';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['username' => $data['username']]);
            return $stmt->fetch();
        } else {
            $sql = 'SELECT * FROM users WHERE phone_number = :phone_number';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['phone_number' => $data['phone_number']]);
            return $stmt->fetch();
        }
    }
}
?>