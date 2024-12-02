<?php  require_once rtrim(BASE_PATH, '/') . '/templates/head.php'; ?>
<?php  require_once rtrim(BASE_PATH, '/') . '/templates/nav.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Elérhető Devizapárok</title>
</head>
<body>

<?php
 require_once rtrim(BASE_PATH, '/') . '/app/controllers/MnbSoapController.php';

$controller = new MnbSoapController();
$currencies = $controller->getCurrencies();

// Ellenőrizzük, hogy a válasz érvényes-e
if (!$currencies) {
    error_log('Nincs érvényes válasz a SOAP kéréstől.');
    echo "Nincs elérhető adat.";
    exit;
}

echo "<h1>Elérhető Devizapárok</h1>";
echo "<ul>";
foreach ($currencies['Currencies']->Currency as $currency) {
    echo "<li>{$currency}</li>";
}
echo "</ul>";
?>

</body>
</html>
<?php include __DIR__ . '/templates/footer.php'; ?>
