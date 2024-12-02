<?php

class View_Loader
{
    private $data = array();
    private $render = FALSE;
    private $selectedItems = FALSE;
    private $style = FALSE;

    public function __construct($viewName)
    {
        // Nézet fájl keresése
        $file = SERVER_ROOT . 'views/' . strtolower($viewName) . '.php';
        if (file_exists($file)) {
            $this->render = $file;  // Elmentjük a fájl elérési útját
            $this->selectedItems = explode("_", $viewName); // Szétválasztjuk a nézet nevét
        } else {
            throw new Exception("A nézet fájl nem található: " . $viewName);  // Hibát dobunk, ha nem található a fájl
        }

        // Stíluslap keresése
        $file = SERVER_ROOT . 'css/' . strtolower($viewName) . '.css';
        if (file_exists($file)) {
            $this->style = SITE_ROOT . 'css/' . strtolower($viewName) . '.css';
        }
    }

    // Változók hozzárendelése a nézethez
    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    // Nézet renderelése a destruktáláskor
    public function __destruct()
    {
        // Készítjük elő az adatokat a nézethez
        $this->data['render'] = $this->render;
        $this->data['selectedItems'] = $this->selectedItems;
        $this->data['style'] = $this->style;

        // Nézet fájl betöltése
        extract($this->data); // Kivonjuk az adatokat változókká
        include($this->render);  // Dinamikusan betöltjük a megfelelő nézet fájlt
    }
}


?>