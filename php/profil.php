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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
        <script src="../js/profil.js" defer></script>
    </head>
    <body>
        <div id="user-info" data-id="<?php echo htmlspecialchars($user_id); ?>"></div>
        <div id="stats"></div>
        <div id="delete_account"></div>
        <div id="change_pwd"></div>
    </body>
</html>