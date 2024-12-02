
<?php require_once rtrim(BASE_PATH, '/') . '/app/models/Kilepes_Model.php';

class KilepesController {
    public function kilepes() {
        // Session törlés, logout logika
        session_unset();  // session változók törlése
        session_destroy(); // session megsemmisítése
        
        // Átirányítás a kilépési oldalra
        header("Location:'/public/index.php?url=kilepes_msg"); 
        exit();
    }

    public function kilepes_msg() {
         require_once rtrim(BASE_PATH, '/') . '/app/views/kilepes.php';  // Kilépési üzenet megjelenítése
    }
}
?>
