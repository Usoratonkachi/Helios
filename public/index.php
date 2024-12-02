<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['userlevel'])) {
    $_SESSION['userlevel'] = '100'; // Alapértelmezett jogosultság látogatónak
}

// Az abszolút elérési út használata
// Ha a config.php fájlt betöltjük, a teljes abszolút elérési utat használjuk
// A webserver gyökér könyvtárát megkapjuk $_SERVER['DOCUMENT_ROOT'] segítségével
// A teljes elérési út megadása, kezdve a dokumentum gyökér könyvtárával
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/core/App.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/core/Controller.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/core/router.php');


// Elindítjuk az alkalmazást
$app = new App();
