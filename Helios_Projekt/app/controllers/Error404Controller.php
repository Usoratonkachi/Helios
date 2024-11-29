<?php
class Error404Controller extends Controller {
    public function index() {
        echo "404 - Az oldal nem található.";
    }

    public function main() {
        $this->index();
    }
}
?>
