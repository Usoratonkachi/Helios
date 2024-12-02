<?php include __DIR__ . '/templates/head.php'; ?>
<?php include __DIR__ . '/templates/nav.php'; ?>


<br>
<br>
<br>
<br>

<!DOCTYPE html>
<html>
<head>
    <title>PDF generáló</title>
    <style>
        form {
            max-width: 400px;
            margin: auto;
        }
        label, select, input[type="submit"] {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        select {
            padding: 5px;
            font-size: 14px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="index.php?url=pdf/generate" method="post">
        <label for="input1">Év:</label>
        <select id="input1" name="input1" required>
            <?php foreach ($versenyek as $verseny): ?>
                <option value="<?= htmlspecialchars($verseny['ev']) ?>"><?= htmlspecialchars($verseny['ev']) ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="input2">Város:</label>
        <select id="input2" name="input2" required>
            <?php foreach ($versenyek as $verseny): ?>
                <option value="<?= htmlspecialchars($verseny['varos']) ?>"><?= htmlspecialchars($verseny['varos']) ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="input3">Nyelv:</label>
        <select id="input3" name="input3" required>
            <?php foreach ($nyelvek as $nyelv): ?>
                <option value="<?= htmlspecialchars($nyelv['nyelv']) ?>"><?= htmlspecialchars($nyelv['nyelv']) ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <input type="submit" value="PDF generálása">
    </form>
</body>
</html>
</html>

<?php include __DIR__ . '/templates/footer.php'; ?>
