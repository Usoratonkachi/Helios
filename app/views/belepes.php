



<?php require_once rtrim(BASE_PATH, '/') . '/app/views/templates/head.php';?>
<?php require_once rtrim(BASE_PATH, '/') . '/app/views/templates/nav.php';?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
</head>
<body>
    <?php

// Jogosultság ellenőrzése
if (isset($_SESSION['userid'])) {
    if ($_SESSION['userlevel'] == '001') { // Jogosultság ellenőrzése
        
    } else {

    }
} else {
    echo "Nincs bejelentkezve!";
}
?>

<?php
if (isset($_SESSION['login_error'])) {
    echo "<p style='color: red;'>".$_SESSION['login_error']."</p>";
    unset($_SESSION['login_error']);
}

// A bejelentkezett felhasználót a session alapján ellenőrizzük
if (isset($_SESSION['userid'])) {
    if ($_SESSION['userid'] == 'Admin') {
        $_SESSION['userlevel'] = '001';  // Ha admin, beállítjuk a megfelelő jogosultságot
    } else {
        $_SESSION['userlevel'] = '100';  // Ha nem admin, beállítjuk a megfelelő jogosultságot
    }
} else {
    $_SESSION['userlevel'] = '111';  // Ha nincs bejelentkezve, látogató jogosultság
}
?>

<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;">

    <h2>Bejelentkezés</h2>
    
    <form action="index.php?url=belepes" method="POST" style="text-align: center;">
        <label for="login">Felhasználónév:</label>
        <input type="text" id="login" name="login" required style="width: 150px; padding: 8px;"><br><br>

        <label for="password">Jelszó:</label>
        <input type="password" id="password" name="password" required style="width: 150px; padding: 8px;"><br><br>

        <button type="submit">Bejelentkezés</button>
    </form>

    <br><br>
    <p>
        <a href="http://heliosprojektview.nhely.hu/Helios_Projekt/public/index.php?url=regist">Szeretne regisztrálni?</a>
    </p>
</div>

</body>
</html>

<?php  require_once rtrim(BASE_PATH, '/') . '/app/views/templates/footer.php'; ?>
