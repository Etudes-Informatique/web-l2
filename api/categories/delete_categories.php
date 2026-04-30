<?php
    session_start();
    header('Content-Type: application/json');

    if (!isset($_SESSION['hasLogged'])) {
        echo json_encode(["success" => false, "error" => "Non connecté"]);
        exit;
    }

    $categoryId = $_POST['id'] ?? null;
    $userId = $_SESSION['id'];

    if (!$categoryId) {
        echo json_encode(["success" => false, "error" => "ID manquant"]);
        exit;
    }

    $connexion = mysqli_connect("inf-mysql.univ-rouen.fr", "beaucart", "23052003", "beaucart2");

    $stmt = $connexion->prepare("DELETE FROM category WHERE id = ? AND identifiant = ?");
    $stmt->bind_param("is", $categoryId, $userId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Erreur SQL"]);
    }
?>