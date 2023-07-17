<?php
abstract class connection {
    protected $DB_TYPE;
    protected $DB_HOST;
    protected $DB_NAME;
    protected $USER;
    protected $PW;
    protected $connection;

    public function __construct() {
        $this->DB_TYPE = 'mysql';
        $this->DB_HOST = 'localhost';
        $this->DB_NAME = 'deha';
        $this->USER = 'root';
        $this->PW = '';
        $this->connection = $this->conn();
    }

    public function conn() {
        try {
            $conn = new PDO("$this->DB_TYPE:host=$this->DB_HOST;dbname=$this->DB_NAME", $this->USER, $this->PW);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch (Exception $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    public function prepareSQL($sql) {
        return $this->connection->prepare($sql);
}
}
class Query extends connection {
    public function all() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->prepareSQL($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->prepareSQL($sql);
        $stmt->execute($data);
    }

    public function delete($data) {
        $sql = "DELETE FROM categories where id = :id";
        $stmt = $this->prepareSQL($sql);
        $stmt->execute($data);
    }

    public function update($data) {
        $sql = "UPDATE categories SET name= :name WHERE id = :id";
        $stmt = $this->prepareSQL($sql);
        $stmt->execute($data);
    }

    public function select($data) {
        $sql = "SELECT * FROM categories WHERE id = $data";
        $stmt = $this->prepareSQL($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}