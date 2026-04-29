<?php
    header('Content-Type: application/json');

    $taskId = $_GET['id'] ?? null;

    if (!$taskId) {
        echo json_encode(["error" => "ID de tâche absent"]);
        exit;
    }

    $connexion = mysqli_connect("localhost", "root", "", "task_manager");

    $stmt = $connexion->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $taskId);
    $stmt->execute();
    $res = $stmt->get_result();

    $task = $res->fetch_assoc();

    if (!$task) {
        echo json_encode(["error" => "Tâche introuvable"]);
    } else {
        echo json_encode($task);
    }
?>