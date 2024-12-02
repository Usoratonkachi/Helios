<?php
class Controller {
    // Az útvonalak központosítása
    protected $modelPath;
    protected $viewPath;
    protected $controllerPath;

    public function __construct() {
        // Beállítjuk az abszolút elérési utakat
        $this->modelPath = $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/models/';
        $this->viewPath = $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/views/';
        $this->controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/Helios_Projekt/app/controllers/';
    }

    // Modell betöltése
    public function model($model) {
        $modelFile = $this->modelPath . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model(); // A modell példányosítása
        } else {
            throw new Exception("A modell fájl nem található: $modelFile");
        }
    }

    // Nézet betöltése
    public function view($view, $data = []) {
        $viewFile = $this->viewPath . $view . '.php';
        if (file_exists($viewFile)) {
            extract($data); // Az adatok változóvá alakítása
            require_once $viewFile;
        } else {
            throw new Exception("A nézet fájl nem található: $viewFile");
        }
    }

    // Vezérlő betöltése
    public function controller($controller) {
        $controllerFile = $this->controllerPath . ucfirst($controller) . 'Controller.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerClass = ucfirst($controller) . 'Controller';
            return new $controllerClass(); // A vezérlő példányosítása
        } else {
            throw new Exception("A vezérlő fájl nem található: $controllerFile");
        }
    }
}

?>
