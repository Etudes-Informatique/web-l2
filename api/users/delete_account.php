<?php
    header('Content-Type: application/json');
    session_start();
    $connexion = mysqli_connect("inf-mysql.univ-rouen.fr", "beaucart", "23052003", "beaucart2");

    if (!isset($_SESSION['hasLogged'])) {
        echo json_encode(["success" => false, "error" => "Non connecté"]);
        exit;
    }

    // ...

    echo json_encode($response);
?>