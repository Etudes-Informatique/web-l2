<?php
    header('Content-Type: application/json');
    session_start();

    if (!isset($_SESSION['hasLogged'])) {
        echo json_encode(["success" => false, "error" => "Non connecté"]);
        exit;
    }

    $userId = $_SESSION['id'];

    $name = $_POST['title'] ?? null;

    if (empty($name)) {
        echo json_encode([
            "success" => false, 
            "error" => "Champs manquants",
            "debug" => $_POST
        ]);
        exit;
    }

    $connexion = mysqli_connect("inf-mysql.univ-rouen.fr", "beaucart", "23052003", "beaucart2");

    if (!$connexion) {
        echo json_encode(["success" => false, "error" => "Échec connexion BDD"]);
        exit;
    }

    $stmt = $connexion->prepare("INSERT INTO category (name, identifiant) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $userId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $connexion->close();
?>