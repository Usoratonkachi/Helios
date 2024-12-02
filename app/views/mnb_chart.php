<?php include __DIR__ . '/templates/head.php'; ?>
<?php include __DIR__ . '/templates/nav.php'; ?>

<br>
<br>
<br>

<!DOCTYPE html>
<html>
<head>
    <title>Árfolyam Lekérdezés</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
</head>
<body>

<?php
require_once __DIR__ . '/../controllers/MnbController.php';

$controller = new MnbController();
$data = $controller->index();

$currencies = (array)$data['currencies']->Curr;

?>

<h2>Árfolyam Lekérdezés</h2>
<form method="post" action="">
    <label for="date">Dátum:</label>
    <input type="date" id="date" name="date" required>
    
    <label for="currency">Deviza:</label>
    <select id="currency" name="currency" required>
        <?php
        foreach ($currencies as $currency) {
            echo "<option value=\"$currency\">$currency</option>";
        }
        ?>
    </select>
    
    <button type="submit">Lekérdezés</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $currency = $_POST['currency'];

    // Napi lekérdezés
    $dailyData = $controller->getRateByDate($date, $currency);
    if ($dailyData && isset($dailyData->Day)) {
        $day = $dailyData->Day;
        echo "<h3>{$date} napi árfolyam a {$currency} devizához:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Dátum</th><th>Deviza</th><th>Árfolyam</th></tr>";
        foreach ($day->Rate as $rate) {
            echo "<tr>";
            echo "<td>{$day['date']}</td>";
            echo "<td>{$currency}</td>";
            echo "<td>{$rate}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nincs elérhető adat erre a napra.</p>";
    }

    // Havi lekérdezés
    $year = date("Y", strtotime($date));
    $month = date("m", strtotime($date));
    $monthlyData = $controller->getMonthlyRates($currency, $year, $month);
    if ($monthlyData && isset($monthlyData->Day)) {
        echo "<h3>{$year} év {$month} havi árfolyam a {$currency} devizához:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Dátum</th><th>Deviza</th><th>Árfolyam</th></tr>";
        $dates = [];
        $rates = [];
        foreach ($monthlyData->Day as $day) {
            $dayDate = (string)$day['date'];
            foreach ($day->Rate as $rate) {
                $dates[] = $dayDate;
                $rates[] = (float)$rate;
                echo "<tr>";
                echo "<td>{$dayDate}</td>";
                echo "<td>{$currency}</td>";
                echo "<td>{$rate}</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    } else {
        echo "<p>Nincs elérhető adat erre a hónapra.</p>";
    }
?>

<canvas id="exchangeRateChart"></canvas>

<script>
    const ctx = document.getElementById('exchangeRateChart').getContext('2d');
    const exchangeRateChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                label: '<?php echo $currency; ?> Árfolyam',
                data: <?php echo json_encode($rates); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day'
                    }
                },
                y: {
                    beginAtZero: false
                }
            }
        }
    });
</script>
<?php
}
?>

</body>
</html>
<?php include __DIR__ . '/templates/footer.php'; ?>
