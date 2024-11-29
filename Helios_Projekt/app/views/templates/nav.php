<?php
require_once 'C:/xampp/htdocs/Helios_Projekt/core/Database.php';
require_once 'C:/xampp/htdocs/Helios_Projekt/core/Menu.php';

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
