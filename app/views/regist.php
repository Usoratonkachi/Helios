<?php require_once rtrim(BASE_PATH, '/') . '/app/views/templates/head.php'; ?>
<?php require_once rtrim(BASE_PATH, '/') . '/app/views/templates/nav.php'; ?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
</head>
<body>
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;">
        <h2>Regisztráció</h2>
        
        <?php
        if (isset($_SESSION['registration_error'])) {
            echo "<p style='color: red;'>".$_SESSION['registration_error']."</p>";
            unset($_SESSION['registration_error']);
        }
        if (isset($_SESSION['registration_success'])) {
            echo "<p style='color: green;'>".$_SESSION['registration_success']."</p>";
            unset($_SESSION['registration_success']);
        }
        ?>

        <form action="index.php?url=regist" method="POST" style="text-align: center;">
            <label for="login">Felhasználónév:</label>
            <input type="text" id="login" name="login" required style="width: 150px; padding: 8px;"><br><br>

            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password" required style="width: 150px; padding: 8px;"><br><br>

            <label for="lastname">Családi név:</label>
            <input type="text" id="lastname" name="lastname" required style="width: 150px; padding: 8px;"><br><br>

            <label for="firstname">Utónév:</label>
            <input type="text" id="firstname" name="firstname" required style="width: 150px; padding: 8px;"><br><br>

            <button type="submit">Regisztráció</button>
        </form>
    </div>
</body>
</html>

<?php require_once rtrim(BASE_PATH, '/') . '/app/views/templates/footer.php'; ?>
