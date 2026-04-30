<?php
header('Content-Type: application/json');
$identifiant = $_GET['identifiant'] ?? null;

if (!$identifiant) {
    echo json_encode(["error" => "Identifiant absent"]);
    exit;
}

$connexion = mysqli_connect("inf-mysql.univ-rouen.fr", "beaucart", "23052003", "beaucart2");
$safe_id = mysqli_real_escape_string($connexion, $identifiant);

$request = "SELECT * FROM tasks WHERE identifiant = '$safe_id'";
$res = mysqli_query($connexion, $request);
$donnees = mysqli_fetch_all($res, MYSQLI_ASSOC);

echo json_encode($donnees);
?>