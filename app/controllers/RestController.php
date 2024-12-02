<?php
 require_once rtrim(BASE_PATH, '/') . '/app/models/Dal_Model.php';
 require_once rtrim(BASE_PATH, '/') . '/app/models/Nyelv_Model.php';
 require_once rtrim(BASE_PATH, '/') . '/app/models/Verseny_Model.php';

class RestController {
    private $dalModel;
    private $nyelvModel;
    private $versenyModel;

    public function __construct() {
        $this->dalModel = new Dal_Model();
        $this->nyelvModel = new Nyelv_Model();
        $this->versenyModel = new Verseny_Model();
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        
        if (isset($_GET['url'])) {
            $resource = $_GET['url'];
        } else {
            $this->sendResponse(400, 'Bad Request');
            return;
        }
        
        $id = $_GET['id'] ?? null;

        switch ($resource) {
            case 'api/dal':
                $this->handleDalRequest($method, $id);
                break;
            case 'api/nyelv':
                $this->handleNyelvRequest($method, $id);
                break;
            case 'api/verseny':
                $this->handleVersenyRequest($method, $id);
                break;
            default:
                $this->sendResponse(404, 'Resource Not Found');
                break;
        }
    }

    private function handleDalRequest($method, $id) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getEntryById($id, 'dal');
                } else {
                    $this->getAllEntries('dal');
                }
                break;
            case 'POST':
                $this->createEntry('dal');
                break;
            case 'PUT':
                $this->updateEntry($id, 'dal');
                break;
            case 'DELETE':
                $this->deleteEntry($id, 'dal');
                break;
            default:
                $this->sendResponse(405, 'Method Not Allowed');
                break;
        }
    }

    private function handleNyelvRequest($method, $id) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getEntryById($id, 'nyelv');
                } else {
                    $this->getAllEntries('nyelv');
                }
                break;
            case 'POST':
                $this->createEntry('nyelv');
                break;
            case 'PUT':
                $this->updateEntry($id, 'nyelv');
                break;
            case 'DELETE':
                $this->deleteEntry($id, 'nyelv');
                break;
            default:
                $this->sendResponse(405, 'Method Not Allowed');
                break;
        }
    }

    private function handleVersenyRequest($method, $id) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getEntryById($id, 'verseny');
                } else {
                    $this->getAllEntries('verseny');
                }
                break;
            case 'POST':
                $this->createEntry('verseny');
                break;
            case 'PUT':
                $this->updateEntry($id, 'verseny');
                break;
            case 'DELETE':
                $this->deleteEntry($id, 'verseny');
                break;
            default:
                $this->sendResponse(405, 'Method Not Allowed');
                break;
        }
    }

    private function getAllEntries($table) {
        $entries = $this->{"{$table}Model"}->{"getAll" . ucfirst($table) . "s"}();
        $this->sendResponse(200, $entries);
    }

    private function getEntryById($id, $table) {
        $entry = $this->{"{$table}Model"}->{"get" . ucfirst($table) . "ById"}($id);
        if ($entry) {
            $this->sendResponse(200, $entry);
        } else {
            $this->sendResponse(404, 'Entry Not Found');
        }
    }

    private function createEntry($table) {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data === null) {
            error_log('Invalid JSON data: ' . file_get_contents('php://input'));
            $this->sendResponse(400, 'Invalid JSON data');
            return;
        }
        if ($this->{"{$table}Model"}->{"create" . ucfirst($table)}($data)) {
            $this->sendResponse(201, 'Entry Created');
        } else {
            error_log('Failed to create entry in table: ' . $table);
            $this->sendResponse(500, 'Internal Server Error');
        }
    }
    

    private function updateEntry($id, $table) {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data === null) {
            $this->sendResponse(400, 'Invalid JSON data');
            return;
        }
        if ($this->{"{$table}Model"}->{"update" . ucfirst($table)}($id, $data)) {
            $this->sendResponse(200, 'Entry Updated');
        } else {
            $this->sendResponse(500, 'Internal Server Error');
        }
    }

    private function deleteEntry($id, $table) {
        if ($this->{"{$table}Model"}->{"delete" . ucfirst($table)}($id)) {
            $this->sendResponse(200, 'Entry Deleted');
        } else {
            $this->sendResponse(500, 'Internal Server Error');
        }
    }

    private function sendResponse($status, $data) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
?>
