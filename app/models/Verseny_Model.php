<?php
class Verseny_Model {
    private $conn;

    public function __construct() {
         require_once rtrim(BASE_PATH, '/') . '/core/Database.php';
        $this->conn = Database::getConnection();
    }

    public function getAllVersenyek() {
        $sql = "SELECT * FROM verseny";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
