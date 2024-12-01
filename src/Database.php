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
    public function update($data, $table) {
        $keys = array_keys($data);
        $values = array_values($data);
        $sql = 'UPDATE ' . $table . ' SET ' . implode(' = ?, ', $keys) . ' = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($values);
    }
    public function delete($id, $table) {
        $sql = 'DELETE FROM ' . $table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
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
        } else {
            $sql = 'SELECT * FROM users WHERE username = :username';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['username' => $data['username']]);
            return $stmt->fetch();
        }
    }
}
?>