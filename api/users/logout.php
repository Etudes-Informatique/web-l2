<?php
    session_start();
    if (isset($_SESSION['hasLogged'])) {
        unset($_SESSION['hasLogged']);
        unset($_SESSION['id']);
        echo "<script>alert('Vous vous êtes déconnecté avec succès.'); window.location.href = '../../html/login.html';</script>";
        exit;
    }
?>