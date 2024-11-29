<?php
// Session logika betöltése
include 'C:/xampp/htdocs/Helios_Projekt/app/helpers/session_helper.php';

echo "Session jogosultság: " . htmlspecialchars($_SESSION['userlevel'] ?? '100') . "<br>";
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include 'C:/xampp/htdocs/Helios_Projekt/app/views/templates/head.php'; ?>
</head>
<body>
    <?php include 'C:/xampp/htdocs/Helios_Projekt/app/views/templates/header.php'; ?>
    <?php include 'C:/xampp/htdocs/Helios_Projekt/app/views/templates/nav.php'; ?>
    <p>Üdvözöljük, <?php echo htmlspecialchars($_SESSION['userfirstname'] ?? 'Vendég') . " " . htmlspecialchars($_SESSION['userlastname'] ?? ''); ?>!</p>
    <main>
        <?php include 'C:/xampp/htdocs/Helios_Projekt/app/views/templates/main.php'; ?>
        <?php include 'C:/xampp/htdocs/Helios_Projekt/app/views/templates/features.php'; ?>
    </main>
    <?php include 'C:/xampp/htdocs/Helios_Projekt/app/views/templates/footer.php'; ?>
</body>
</html>
