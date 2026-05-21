<?php
session_start();
header('Content-Type: application/json');

$connexion = mysqli_connect("inf-mysql.univ-rouen.fr", "beaucart", "23052003", "beaucart2");
if (!$connexion) {
    echo json_encode(["success" => false, "error" => mysqli_connect_error()]);
    exit;
}

$search   = trim($_REQUEST['q'] ?? '');
$priority = trim($_REQUEST['p'] ?? '');
$status   = trim($_REQUEST['s'] ?? '');

if (strlen($search) < 2) {
    echo json_encode([]);
    exit;
}

$conditions = ["(title LIKE ? OR description LIKE ?)"];
$params     = [$search = "%$search%", $search];
$types      = "sss";

if ($priority !== '') {
    $conditions[] = "priority = ?";
    $params[]     = $priority;
    $types       .= "s";
}

if ($status !== '') {
    $conditions[] = "status = ?";
    $params[]     = $status;
    $types       .= "s";
}
$id = $_SESSION['id']; 
$where = implode(" AND ", $conditions);
$stmt  = $connexion->prepare("SELECT * FROM tasks WHERE identifiant = ? AND $where LIMIT 10");
$stmt->bind_param($types, $id, ...$params);

if ($stmt->execute()) {
    $tasks = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($tasks);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$connexion->close();