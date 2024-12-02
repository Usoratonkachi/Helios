<?php
// Alapértelmezett session változók
if (!isset($_SESSION['userid'])) $_SESSION['userid'] = 0;
if (!isset($_SESSION['userfirstname'])) $_SESSION['userfirstname'] = "";
if (!isset($_SESSION['userlastname'])) $_SESSION['userlastname'] = "";
if (!isset($_SESSION['userlevel'])) $_SESSION['userlevel'] = "100"; // Alapértelmezett jogosultság

// Alap fájlok betöltése
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/core/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/core/App.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/core/Controller.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/core/View.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/core/Menu.php');

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

// SOAP nézet hozzáadása az `mnb` útvonalhoz
if (isset($_GET['url']) && $_GET['url'] === 'mnb') {
    include $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/views/mnb_chart.php';
    exit;
}

// Elérhető devizapárok nézet hozzáadása
if (isset($_GET['url']) && $_GET['url'] === 'mnb_currencies') {
    include $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/views/mnb_currencies.php';
    exit;
}

if (isset($_GET['url']) && $_GET['url'] === 'soap') {
    include $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/views/soap.php';
    exit;
}

// REST API endpointok
$restEndpoints = ['api/dal', 'api/nyelv', 'api/verseny'];
if (in_array($_GET['url'] ?? '', $restEndpoints)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/controllers/RestController.php';
    $controller = new RestController();
    $controller->handleRequest();
    exit;
}

// SOAP szerver
if (isset($_GET['url']) && $_GET['url'] === 'soap/server') {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/controllers/SoapServerController.php';
    $controller = new SoapServerController();
    $controller->handle();
    exit;
}

// SOAP kliens
if (isset($_GET['url']) && $_GET['url'] === 'soap/client') {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/controllers/SoapClientController.php';
    $controller = new SoapClientController();
    $controller->testSoap();
    exit;
}

// Vezérlő fájl elérési útja
$controllerFile = ucfirst($page) . 'Controller.php';
$controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/controllers/' . $controllerFile;

// Ha a vezérlő fájl nem létezik, hiba helyett az alapértelmezett vezérlőt töltjük be
if (!file_exists($controllerPath)) {
    $controllerFile = "MainController.php";
    $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/controllers/' . $controllerFile;
    $page = "main"; // Alapértelmezett vezérlő oldal
}

// Vezérlő fájl betöltése
// Vezérlő fájl betöltése
include_once($controllerPath); // Használjuk include_once-t itt

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

// Új végpont hozzáadása a PDF generáláshoz
if (isset($_GET['url']) && $_GET['url'] === 'pdf') {
    require_once rtrim(BASE_PATH, '/') . '/app/controllers/PDFController.php';
    $controller = new PdfController();
    $controller->index();
    exit;
}

if (isset($_GET['url']) && $_GET['url'] === 'pdf/generate') {
    require_once rtrim(BASE_PATH, '/') . '/app/controllers/PDFController.php';
    $controller = new PdfController();
    $controller->generate();
    exit;
}

// Modellek automatikus betöltése
spl_autoload_register(function ($className) {
    $file = $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/models/' . strtolower($className) . ".php";
    if (file_exists($file)) {
        include_once($file);
    }
});
?>
