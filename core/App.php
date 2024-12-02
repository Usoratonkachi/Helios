<?php

class App
{
    protected $controller = 'MainController'; // Alapértelmezett vezérlő
    protected $method = 'index'; // Alapértelmezett metódus
    protected $params = []; // Paraméterek az URL-ből

    public function __construct()
    {
        // URL feldolgozása a router alapján
        $url = $this->parseUrl();

        // Vezérlő keresése
        if (!empty($url[0])) {
            // Ellenőrizzük, hogy a vezérlő fájl létezik-e
            $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/controllers/' . ucfirst($url[0]) . 'Controller.php';
            if (file_exists($controllerPath)) {
                $this->controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]); // eltávolítjuk az URL-ből a vezérlő nevét

                // Alapértelmezett metódus beállítása a vezérlőhöz
                if ($this->controller == 'BelepesController') {
                    $this->method = 'login'; // BelepesController esetén a login metódus az alapértelmezett
                } elseif ($this->controller == 'KilepesController') {
                    $this->method = 'kilepes'; // KilepesController esetén a kilepes metódus az alapértelmezett
                } elseif ($this->controller == 'RegistController') {
                    $this->method = 'register'; // RegistController esetén a register metódus az alapértelmezett
                } else {
                    $this->method = 'index'; // Más vezérlők esetén az index metódus az alapértelmezett
                }
            } else {
                // Ha nem található, akkor az alapértelmezett vezérlőt használjuk
                $this->controller = 'MainController';
                $this->method = 'index'; // Alapértelmezett metódus az index
            }
        }

        // Fájl betöltése
        require_once $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Metódus keresése
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1]; // Beállítjuk a metódust, ha létezik
            unset($url[1]); // eltávolítjuk a metódust az URL-ből
        }

        // Paraméterek beállítása
        $this->params = $url ? array_values($url) : []; // Paraméterek beállítása, ha léteznek

        // Vezérlő meghívása
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // URL parszolása
    protected function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)); // URL szétbontása
        }
        return [];
    }
}
?>
