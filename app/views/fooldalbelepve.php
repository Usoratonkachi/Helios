<?php
// Session logika betöltése
 require_once rtrim(BASE_PATH, '/') . 'app/helpers/session_helper.php';

echo "Session jogosultság: " . htmlspecialchars($_SESSION['userlevel'] ?? '100') . "<br>";
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <?php  require_once rtrim(BASE_PATH, '/') . '/app/views/templates/head.php'; ?>
</head>
<body>
    <?php  require_once rtrim(BASE_PATH, '/') . '/app/views/templates/header.php'; ?>
    <?php  require_once rtrim(BASE_PATH, '/') . '/app/views/templates/nav.php'; ?>
    <p>Üdvözöljük, <?php echo htmlspecialchars($_SESSION['userfirstname'] ?? 'Vendég') . " " . htmlspecialchars($_SESSION['userlastname'] ?? ''); ?>!</p>
    <main>
        <?php  require_once rtrim(BASE_PATH, '/') . '/app/views/templates/main.php'; ?>
        <?php  require_once rtrim(BASE_PATH, '/') . '/app/views/templates/features.php'; ?>
    </main>
    <?php  require_once rtrim(BASE_PATH, '/') . '/app/views/templates/footer.php'; ?>
</body>
</html>
