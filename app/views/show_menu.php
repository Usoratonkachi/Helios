<?php
 require_once rtrim(BASE_PATH, '/') . '/core/Database.php';
 require_once rtrim(BASE_PATH, '/') . 'core/Menu.php';

if (!isset($_SESSION['userlevel'])) {
    $_SESSION['userlevel'] = '100'; // Alapértelmezett jogosultság
}

$userLevel = $_SESSION['userlevel'];
$menuItems = Menu::getMenuItems($userLevel);

function renderMenu($menuItems) {
    $menuTree = buildMenuTree($menuItems);
    echo "<nav><ul>";
    renderMenuTree($menuTree);
    echo "</ul></nav>";
}

function buildMenuTree($menuItems, $parentId = '') {
    $branch = [];
    foreach ($menuItems as $item) {
        if ($item['szulo'] == $parentId) {
            // Az URL generálása javítva
            $item['url'] = generateUrl($item['url']); // URL generálás
            $children = buildMenuTree($menuItems, $item['url']);
            if ($children) {
                $item['children'] = $children;
            }
            $branch[] = $item;
        }
    }
    return $branch;
}

function renderMenuTree($menuTree) {
    foreach ($menuTree as $item) {
        echo "<li><a href='" . htmlspecialchars($item['url']) . "'>" . htmlspecialchars($item['nev']) . "</a>";
        if (isset($item['children'])) {
            echo "<ul>";
            renderMenuTree($item['children']);
            echo "</ul>";
        }
        echo "</li>";
    }
}

// URL generálás a paraméterek alapján
function generateUrl($url) {
    // Az URL végi perjellel együtt biztosítjuk, hogy a megfelelő URL formátumot kapjuk
    $url = rtrim($url, '/'); // Eltávolítjuk a végső perjelet, ha van
    $urlParts = explode('/', $url);

    // Ha szükséges, további URL komponenseket adhatunk hozzá itt
    // Például a URL generálás közben hozzáadhatunk paramétereket vagy manipulálhatjuk az URL-t

    return "/" . implode('/', $urlParts); // Az URL-t újraépítjük
}

renderMenu($menuItems);
?>
