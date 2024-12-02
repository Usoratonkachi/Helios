<?php
// Helyes fájl elérési út
require_once rtrim(BASE_PATH, '/') . '/config/config.php';
// Helyes fájl elérési út
require_once rtrim(BASE_PATH, '/') . '/core/Database.php';


class Belepes_Model {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getUser($username) {
        $connection = Database::getConnection();
        $sql = "SELECT id, csaladi_nev, utonev, jogosultsag, jelszo FROM felhasznalok WHERE bejelentkezes = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function get_data($vars) {
        $retData = ['eredmeny' => "", 'uzenet' => ""];

        try {
            $connection = Database::getConnection();
            $sql = "SELECT id, csaladi_nev, utonev, jogosultsag, jelszo FROM felhasznalok WHERE bejelentkezes = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $vars['login']);
            $stmt->execute();
            $result = $stmt->get_result();
            $felhasznalo = $result->fetch_assoc();

            if ($felhasznalo) {
                if (hash('sha1', $vars['password']) === $felhasznalo['jelszo']) {
                    $retData['eredmeny'] = "OK";
                    $retData['userlastname'] = $felhasznalo['csaladi_nev'];
                    $retData['userfirstname'] = $felhasznalo['utonev'];
                    $retData['userlevel'] = $felhasznalo['jogosultsag'];
                    $retData['userid'] = $felhasznalo['id'];
                } else {
                    $retData['eredmeny'] = "ERROR";
                    $retData['uzenet'] = "Helytelen jelszó!";
                }
            } else {
                $retData['eredmeny'] = "ERROR";
                $retData['uzenet'] = "Felhasználó nem található!";
            }
        } catch (mysqli_sql_exception $e) {
            $retData['eredmeny'] = "ERROR";
            $retData['uzenet'] = "Adatbázis hiba: " . $e->getMessage();
        }

        return $retData;
    }
}
?>
