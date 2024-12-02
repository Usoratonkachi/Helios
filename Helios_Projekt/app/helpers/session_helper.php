<?php
function initialize_user_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Győződj meg róla, hogy a session fut
    }

    // Ellenőrizzük, hogy létezik-e aktív felhasználói session
    $user_authenticated = isset($_SESSION['userid']); // Ha van userid, akkor be van jelentkezve

    // Ha admin vagy bejelentkezett felhasználó, akkor állítsuk be a jogosultságot
    if ($user_authenticated && $_SESSION['userlevel'] == '001') {
        $_SESSION['userlevel'] = '001'; // Admin jogosultság
    } elseif ($user_authenticated) {
        $_SESSION['userlevel'] = '111'; // Bejelentkezett felhasználó
    } else {
        $_SESSION['userlevel'] = '100'; // Látogató
    }
}


// Meghívás (ha szükséges)
initialize_user_session();
