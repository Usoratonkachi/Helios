<?php
// A helyes elérési útvonal beállítása
require_once __DIR__ . '/../core/Database.php';  // Ha a fájl a 'core' mappában van

class Menu {
    public static function getMenuItems($userLevel) {
        $connection = Database::getConnection();
        $query = "SELECT url, nev, szulo, jogosultsag, sorrend FROM menu ORDER BY sorrend";
        $result = $connection->query($query);

        if (!$result) {
            die("SQL hiba: " . $connection->error);
        }

        $menuItems = [];
        while ($row = $result->fetch_assoc()) {
            $itemLevels = explode(',', $row['jogosultsag']);
            if (self::hasAccess($userLevel, $itemLevels)) {
                $menuItems[] = $row;
            }
        }
        return $menuItems;
    }

    private static function hasAccess($userLevel, $itemLevels) {
        if ($userLevel == '100' && in_array('100', $itemLevels)) {
            return true;
        } elseif ($userLevel == '111' && (in_array('100', $itemLevels) || in_array('111', $itemLevels))) {
            return true;
        } elseif ($userLevel == '001' && (in_array('100', $itemLevels) || in_array('111', $itemLevels) || in_array('001', $itemLevels))) {
            return true;
        }
        return false;
    }

    public static function buildMenuTree($menuItems, $parentId = '') {
        $branch = [];
        foreach ($menuItems as $item) {
            if ($item['szulo'] == $parentId) {
                $item['url'] = self::generateUrl($item['url']); 
                $children = self::buildMenuTree($menuItems, $item['url']);
                if ($children) {
                    $item['children'] = $children;
                }
                // Elrejtjük a belépési menüpontot, ha a felhasználó be van jelentkezve
                if ($item['url'] !== "index.php?url=belepes" || (isset($_SESSION['userid']) && $_SESSION['userid'] == 0)) {
                    $branch[] = $item;
                }
            }
        }
        return $branch;
    }

    public static function renderMenuTree($menuTree) {
        foreach ($menuTree as $item) {
            echo "<li><a href='" . htmlspecialchars($item['url']) . "'>" . htmlspecialchars($item['nev']) . "</a>";
            if (isset($item['children'])) {
                echo "<ul>";
                self::renderMenuTree($item['children']);
                echo "</ul>";
            }
            echo "</li>";
        }

        // Kilépés menüpont hozzáadása, ha a felhasználó be van jelentkezve
        if (isset($_SESSION['userid']) && $_SESSION['userid'] != 0) {
            echo "<li><a href='/Helios_Projekt/public/index.php?url=kilepes'>Kilépés</a></li>";
        }
    }

    private static function generateUrl($url) {
        // Ha nincs megadva URL, alapértelmezettként a 'index.php' használata
        if (empty($url)) {
            return "index.php?url=belepes";  // Például a 'belepes' oldalra mutató URL
        }
        
        // URL végi perjel eltávolítása és query paraméterek generálása
        $url = rtrim($url, '/');  // Eltávolítjuk a végső perjelet, ha van
        return "index.php?url=" . urlencode($url);  // URL-enként átadjuk a kívánt formátumot
    }
}
?>
