<?php
require_once 'app/models/Dal_Model.php';

class SoapServerController {
    public function getAllEntries() {
        $model = new Dal_Model();
        return $model->getAllEntries();
    }
}

// SOAP szerver indítása
$server = new SoapServer(null, ['uri' => "http://localhost/Helios-projekt/soap"]);
$server->setClass('Soap_Server_Controller');
$server->handle();
?>
