<?php
    session_start();
    if (!isset($_SESSION['hasLogged'])) {
        header('Location: ../index.php');
        exit();
    }
    $user_id = $_SESSION['id'];
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Votre Profil</title>
        <link rel="stylesheet" href="../css/main.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
        <script src="../js/profil.js" defer></script>
    </head>
    <body>
        <div id="user-info" data-id="<?php echo htmlspecialchars($user_id); ?>"></div>
        <header id="head">
            <div id="logo">
                <a href="../index.php"><img src="../img/logo.png" alt="TaskManager"></a>
            </div>
            <div id="headBoutons">
                <a href="../index.php" id="profil">Accueil</a>
                <a href="../api/users/logout.php" id="log_off">Se déconnecter<img src="../img/se-deconnecter.png" alt="Logout"></a>
            </div>
        </header>
        <div id="homeMain">
            <h1>Mon profil</h1>
            <p>Stats</p>
        </div>
        <div id="stats"></div>
        <div id="stats-psw">
            <div id="change_pwd"></div>
            <div id="delete_account"></div>
        </div>
    </body>
</html>