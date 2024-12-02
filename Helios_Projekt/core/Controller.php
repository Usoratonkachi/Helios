<?php
class Controller {
    // Modell betöltése
    public function model($model) {
        $modelPath = '../app/models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model();
        } else {
            die("A modell fájl nem található: $modelPath");
        }
    }

    // Nézet betöltése
    public function view($view, $data = []) {
        $viewPath = '../app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            // Az adatok átadása a nézetnek
            extract($data); 
            require_once $viewPath;
        } else {
            die("A nézet fájl nem található: $viewPath");
        }
    }

    // Vezérlő fájl betöltése
    public function controller($controller) {
        $controllerPath = '../app/controllers/' . $controller . 'Controller.php';
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            // A vezérlő példányosítása
            $controllerClass = ucfirst($controller) . 'Controller';
            return new $controllerClass();
        } else {
            die("A vezérlő fájl nem található: $controllerPath");
        }
    }
}
?>
