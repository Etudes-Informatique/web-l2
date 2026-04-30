<?php
    session_start();
    if (isset($_SESSION['hasLogged'])) {
        unset($_SESSION['hasLogged']);
        unset($_SESSION['id']);
        echo "<p>Vous vous êtes déconnecté !</p>";
        echo "<button onclick=\"window.location.href='../../index.php'\">Retour à l'Acceuil</button>";
        exit;
    }
?>