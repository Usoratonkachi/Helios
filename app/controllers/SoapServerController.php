<?php
 require_once rtrim(BASE_PATH, '/') . '/config/config.php';
 require_once rtrim(BASE_PATH, '/') . '/core/Database.php';
 require_once rtrim(BASE_PATH, '/') . '/app/models/Dal_Model.php';
 require_once rtrim(BASE_PATH, '/') . '/app/models/Nyelv_Model.php';
 require_once rtrim(BASE_PATH, '/') . '/app/models/Verseny_Model.php';

class SoapServerController {
    public function getAllDals() {
        $dalModel = new Dal_Model();
        return $dalModel->getAllDals();
    }

    public function getAllNyelvek() {
        $nyelvModel = new Nyelv_Model();
        return $nyelvModel->getAllNyelvek();
    }

    public function getAllVersenyek() {
        $versenyModel = new Verseny_Model();
        return $versenyModel->getAllVersenyek();
    }

    public function handle() {
        $server = new SoapServer(null, [
            'uri' => "http://heliosprojektview.nhely.hu/public/index.php?url=soap/server"
        ]);
        $server->setClass('SoapServerController');
        $server->handle();
    }
}
?>
