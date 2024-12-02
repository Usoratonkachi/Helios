<?php
// Alapértelmezett konstansok
define('SITE_ROOT', 'Helios_Projekt/app/views/');
define('BASE_URL', 'http://heliosprojektview.nhely.hu/Helios_Projekt/public/');  
define('SERVER_ROOT', __DIR__ . ''); 
define('TEMPLATE_PATH', __DIR__ . 'Helios_Projekt/app/views/templates/');
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . 'Helios_Projekt');  // ROOT könyvtár

// Adatbázis kapcsolati beállítások
define('DB_HOST', 'localhost');
define('DB_USER', 'euvision');  // Frissített felhasználónév
define('DB_PASS', '123456');    // Frissített jelszó
define('DB_NAME', 'euvision');  // Frissített adatbázis név

// Szkriptek és sablonok elérési útja
set_include_path(get_include_path() . PATH_SEPARATOR . 'Helios_Projekt/app/templates');
?>
