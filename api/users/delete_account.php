<?php
    header('Content-Type: application/json');
    session_start();
    $connexion = mysqli_connect("localhost", "root", "", "task_manager");

    if (!isset($_SESSION['hasLogged'])) {
        echo json_encode(["success" => false, "error" => "Non connecté"]);
        exit;
    }

    // ...

    echo json_encode($response);
?>