<?php
// Helyes fájl elérési út
require_once rtrim(BASE_PATH, '/') . '/core/Database.php';
// Helyes fájl elérési út
require_once rtrim(BASE_PATH, '/') . '/app/models/Belepes_Model.php';


class BelepesController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['login'];
            $password = $_POST['password'];

            $belepesModel = new Belepes_Model(Database::getConnection());

            // Felhasználói adatok lekérése az adatbázisból
            $user = $belepesModel->getUser($username);

            if ($user) {
                // Jelszó ellenőrzése
                if (sha1($password) === $user['jelszo']) {
                    // Session változók beállítása
                    $_SESSION['userid'] = $user['id'];
                    $_SESSION['userlastname'] = $user['csaladi_nev'];
                    $_SESSION['userfirstname'] = $user['utonev'];
                    $_SESSION['userlevel'] = $user['jogosultsag'];

                    // Átirányítás a főoldalra
                    header('Location: ../public/index.php');
                    exit();
                } else {
                    $_SESSION['login_error'] = 'Hibás jelszó!';
                }
            } else {
                $_SESSION['login_error'] = 'A felhasználónév nem található!';
            }

            header('Location: ../public/index.php?url=belepes');
            exit();
        } else {
            require_once rtrim(BASE_PATH, '/') . '/app/views/belepes.php';
  // Bejelentkezési űrlap megjelenítése
        }
    }
}
?>
