<?php
require_once 'app/models/Dal_Model.php';

class RestController {
    public function handleRequest() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        $model = new Dal_Model();

        switch ($requestMethod) {
            case 'GET':
                if ($id) {
                    echo json_encode($model->getEntryById($id));
                } else {
                    echo json_encode($model->getAllEntries());
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($model->createEntry($data));
                break;
            case 'PUT':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($model->updateEntry($id, $data));
                break;
            case 'DELETE':
                echo json_encode($model->deleteEntry($id));
                break;
            default:
                echo json_encode(["message" => "Method not allowed"]);
        }
    }
}
?>
