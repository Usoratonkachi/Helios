<?php
class View {
    public function render($view, $data = []) {
        require_once '../app/views/' . $view . '.php';
    }
}
?>
