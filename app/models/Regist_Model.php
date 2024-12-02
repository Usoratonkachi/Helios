<?php
class Regist_Model {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getUser($username) {
        $stmt = $this->db->prepare("SELECT * FROM felhasznalok WHERE bejelentkezes = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function createUser($lastname, $firstname, $username, $hashedPassword, $userlevel) {
        $stmt = $this->db->prepare("INSERT INTO felhasznalok (csaladi_nev, utonev, bejelentkezes, jelszo, jogosultsag) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$lastname, $firstname, $username, $hashedPassword, $userlevel]);

        // Az újonnan beszúrt felhasználó ID-jának visszaadása
        if ($result) {
            $userid = $this->db->insert_id;
            return ['result' => $result, 'userid' => $userid];
        }

        return false;
    }
}
?>
