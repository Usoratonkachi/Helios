<?php
 require_once rtrim(BASE_PATH, '/') . '/core/Database.php';
 require_once rtrim(BASE_PATH, '/') . '/core/Menu.php';
 require_once rtrim(BASE_PATH, '/') . '/app/models/Regist_Model.php';

class RegistController {
    public function showRegistrationForm() {
         require_once rtrim(BASE_PATH, '/') . '/app/views/regist.php';  // Regisztrációs űrlap megjelenítése
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['login'];
            $password = $_POST['password'];
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $userlevel = '111'; // Alapértelmezett felhasználói szint

            $registModel = new Regist_Model(Database::getConnection());

            // Ellenőrizzük, hogy létezik-e már a felhasználónév
            if ($registModel->getUser($username)) {
                $_SESSION['registration_error'] = 'A felhasználónév már foglalt!';
                header('Location: ../public/index.php?url=regist');
                exit();
            }

            // Jelszó hash-elése
            $hashedPassword = sha1($password);

            // Felhasználó hozzáadása az adatbázisba
            $result = $registModel->createUser($lastname, $firstname, $username, $hashedPassword, $userlevel);

            if ($result['result']) {
                $_SESSION['registration_success'] = 'Sikeres regisztráció!';
                header('Location: ../public/index.php?url=belepes');  // Átirányítás a bejelentkezéshez
                exit();
            } else {
                $_SESSION['registration_error'] = 'Hiba történt a regisztráció során!';
                header('Location: ../public/index.php?url=regist');
                exit();
            }
        } else {
            $this->showRegistrationForm();  // Ha nem POST a kérés, akkor a regisztrációs űrlap megjelenítése
        }
    }
}
?>
