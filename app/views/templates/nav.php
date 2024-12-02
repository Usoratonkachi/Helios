<?php
// Az adatbázis fájlok betöltése
require_once rtrim(BASE_PATH, '/') . '/core/Database.php';
require_once rtrim(BASE_PATH, '/') . '/core/Menu.php';

// Session kezelés
if (!isset($_SESSION['userlevel'])) {
    $_SESSION['userlevel'] = '100'; // Alapértelmezett jogosultság
}

$userLevel = $_SESSION['userlevel'];
$menuItems = Menu::getMenuItems($userLevel);

// Menüfa létrehozása
$menuTree = Menu::buildMenuTree($menuItems);

// Menü renderelése
echo "<nav id='nav'><ul>";
Menu::renderMenuTree($menuTree);
echo "</ul></nav>";
?>
