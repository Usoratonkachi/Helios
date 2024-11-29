<?php
class Dal_Model {
    private $conn;

    public function __construct() {
        require 'database.php';
        $this->conn = $conn;
    }

    public function getAllEntries() {
        $sql = "SELECT * FROM dal";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEntryById($id) {
        $sql = "SELECT * FROM dal WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createEntry($data) {
        $sql = "INSERT INTO dal (ev, sorrend, orszag, nyelv, eloado, eredeti, magyar, helyezes, pontszam) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iissssssi', $data['ev'], $data['sorrend'], $data['orszag'], $data['nyelv'], $data['eloado'], $data['eredeti'], $data['magyar'], $data['helyezes'], $data['pontszam']);
        return $stmt->execute();
    }

    public function updateEntry($id, $data) {
        $sql = "UPDATE dal SET ev = ?, sorrend = ?, orszag = ?, nyelv = ?, eloado = ?, eredeti = ?, magyar = ?, helyezes = ?, pontszam = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iissssssi', $data['ev'], $data['sorrend'], $data['orszag'], $data['nyelv'], $data['eloado'], $data['eredeti'], $data['magyar'], $data['helyezes'], $data['pontszam'], $id);
        return $stmt->execute();
    }

    public function deleteEntry($id) {
        $sql = "DELETE FROM dal WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
