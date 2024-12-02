<?php
session_start();

if (!isset($_SESSION['userlevel'])) {
    $_SESSION['userlevel'] = '100'; // Alapértelmezett jogosultság látogatónak
}

// Folytasd a szokásos kódot...
// Beleértve a router, controller betöltését és egyebeket.


// Először is betöltjük a szükséges fájlokat
require_once '../config/config.php';
require_once '../core/App.php';
require_once '../core/Controller.php';
require_once '../core/router.php'; // Router betöltése


$app = new App();
