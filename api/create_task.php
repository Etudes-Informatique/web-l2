<?php
    header('Content-Type: application/json');
    session_start();

    if (!isset($_SESSION['hasLogged'])) {
        echo json_encode(["success" => false, "error" => "Non connecté"]);
        exit;
    }

    $userId = $_SESSION['id'];

    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $priority = $_POST['priority'] ?? null;
    $deadline = !empty($_POST['deadline']) ? $_POST['deadline'] : null;


    if (empty($title) || empty($description) || empty($priority)) {
        echo json_encode([
            "success" => false, 
            "error" => "Champs manquants",
            "debug" => $_POST
        ]);
        exit;
    }

    $connexion = mysqli_connect("localhost", "root", "", "task_manager");

    if (!$connexion) {
        echo json_encode(["success" => false, "error" => "Échec connexion BDD"]);
        exit;
    }

    $stmt = $connexion->prepare("INSERT INTO tasks (identifiant, deadline, title, priority, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $userId, $deadline, $title, $priority, $description);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $connexion->close();
?>