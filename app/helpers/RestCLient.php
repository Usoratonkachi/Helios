<?php
class RestClient {
    private $baseUrl;

    public function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    public function get($endpoint) {
        $url = $this->baseUrl . $endpoint;
        return $this->request('GET', $url);
    }

    public function post($endpoint, $data) {
        $url = $this->baseUrl . $endpoint;
        return $this->request('POST', $url, $data);
    }

    public function put($endpoint, $data) {
        $url = $this->baseUrl . $endpoint;
        return $this->request('PUT', $url, $data);
    }

    public function delete($endpoint) {
        $url = $this->baseUrl . $endpoint;
        return $this->request('DELETE', $url);
    }

    private function request($method, $url, $data = null) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
?>
