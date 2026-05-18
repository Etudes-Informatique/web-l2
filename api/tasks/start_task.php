<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['hasLogged'])) {
    echo json_encode(["success" => false, "error" => "Non connecté"]);
    exit;
}

$taskId = $_POST['id'] ?? null;
$userId = $_SESSION['id'];

if (!$taskId) {
    echo json_encode(["success" => false, "error" => "ID manquant"]);
    exit;
}

$connexion = mysqli_connect("localhost", "root", "", "task_manager");

$stmt = $connexion->prepare("UPDATE tasks SET status = 'En Cours' WHERE id = ? AND identifiant = ?");
$stmt->bind_param("is", $taskId, $userId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Erreur SQL"]);
}
?>