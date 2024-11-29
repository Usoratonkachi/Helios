<?php
class SoapClientController {
    public function testSoap() {
        $client = new SoapClient(null, ['location' => "http://localhost/Helios-projekt/soap", 'uri' => "http://localhost/Helios-projekt/soap"]);
        $result = $client->getAllEntries();
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
?>
