<?php

// Alapértelmezett session változók
if (!isset($_SESSION['userid'])) $_SESSION['userid'] = 0;
if (!isset($_SESSION['userfirstname'])) $_SESSION['userfirstname'] = "";
if (!isset($_SESSION['userlastname'])) $_SESSION['userlastname'] = "";
if (!isset($_SESSION['userlevel'])) $_SESSION['userlevel'] = "100"; // Alapértelmezett jogosultság

// Alap fájlok betöltése
require_once '../config/config.php';
require_once '../core/Database.php';
require_once '../core/App.php';
require_once '../core/Controller.php';
require_once '../core/View.php';
require_once '../core/Menu.php';

// URL paraméterek feldolgozása
$request = isset($_GET['url']) ? rtrim($_GET['url'], '/') : ""; // URL végéről "/" eltávolítása
$page = "main"; // Alapértelmezett oldal
$methodname = "index"; // Alapértelmezett metódus
$params = [];

if ($request) {
    $params = explode('/', $request);
    $page = array_shift($params); // Főoldal (pl. belepes)
    $methodname = !empty($params) ? array_shift($params) : $methodname; // Ha van aloldal, az lesz a metódus, különben alapértelmezett
}

// Vezérlő fájl elérési útja
$controllerFile = ucfirst($page) . 'Controller.php';
$controllerPath = "../app/controllers/" . $controllerFile;

// Ha a vezérlő fájl nem létezik, hiba helyett az alapértelmezett vezérlőt töltjük be
if (!file_exists($controllerPath)) {
    $controllerFile = "MainController.php";
    $controllerPath = "../app/controllers/" . $controllerFile;
    $page = "main"; // Alapértelmezett vezérlő oldal
}

// Vezérlő fájl betöltése
include_once($controllerPath);

// Vezérlő osztály példányosítása
$controllerClass = ucfirst($page) . 'Controller';
if (class_exists($controllerClass)) {
    // Adatbázis kapcsolat előkészítése
    $database = Database::getConnection();

    // Controller példányosítása az adatbázis kapcsolattal
    $controller = new $controllerClass($database);

    // Csak akkor hívunk metódust, ha létezik
    if (method_exists($controller, $methodname)) {
        call_user_func_array([$controller, $methodname], $params);
    }
}

// Ha a 'regist' URL van megadva, akkor hívjuk a regisztrációs folyamatot
if (isset($_GET['url']) && $_GET['url'] == 'regist') {
    $database = Database::getConnection();
    $controller = new RegistController($database);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $controller->register();  // Regisztráció feldolgozása
    } else {
        $controller->showRegistrationForm();  // Regisztrációs űrlap megjelenítése
    }
}

// Ha a 'kilepes' URL van megadva, akkor hívjuk a kilépési folyamatot
if (isset($_GET['url']) && $_GET['url'] == 'kilepes') {
    $controller = new KilepesController();
    $controller->kilepes(); // Kilépési folyamat kezelése
}

// REST API endpoint
if (isset($_GET['url']) && $_GET['url'] === 'api/dal') {
    require_once 'app/controllers/RestController.php';
    $controller = new RestController();
    $controller->handleRequest();
    exit;
}

// SOAP szerver
if (isset($_GET['url']) && $_GET['url'] === 'soap/server') {
    require_once 'app/controllers/SoapServerController.php';
    exit;
}

// SOAP kliens
if (isset($_GET['url']) && $_GET['url'] === 'soap/client') {
    require_once 'app/controllers/SoapClientController.php';
    $controller = new SoapClientController();
    $controller->testSoap();
    exit;
}


// Modellek automatikus betöltése
spl_autoload_register(function ($className) {
    $file = "../app/models/" . strtolower($className) . ".php";
    if (file_exists($file)) {
        include_once($file);
    }
});
?>
