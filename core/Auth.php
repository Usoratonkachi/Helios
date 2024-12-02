<?php


// Ha nincs bejelentkezve, átirányítjuk a login oldalra
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

// Ha be van jelentkezve, akkor elérhetők a session adatok
echo "Üdvözöllek, " . $_SESSION['userfirstname'] . " " . $_SESSION['userlastname'] . "!";
?>