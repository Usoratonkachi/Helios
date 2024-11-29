<?php include __DIR__ . '/templates/head.php'; ?>
<?php include __DIR__ . '/templates/nav.php'; ?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kilépés</title>
</head>
<body>
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;">
        <h2>Kilépés</h2>
        <p>Sikeresen kijelentkeztél. Visszontlátásra kedves <?php echo $_SESSION['userlastname'] . " " . $_SESSION['userfirstname']; ?>!</p>
        <p>A rendszert biztonságosan elhagytad.</p>
        <p><a href="/Helios_Projekt/public/index.php">Vissza a főoldalra</a></p>
    </div>
</body>
</html>
<?php include 'C:/xampp/htdocs/Helios_Projekt/app/views/templates/footer.php'; ?>
