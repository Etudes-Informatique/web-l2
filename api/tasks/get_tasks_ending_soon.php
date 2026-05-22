<?php
    header('Content-Type: application/json');
    $identifiant = $_GET['identifiant'] ?? null;

    if (!$identifiant) {
        echo json_encode(["error" => "Identifiant absent"]);
        exit;
    }

    $connexion = mysqli_connect("localhost", "root", "", "task_manager");
    $safe_id = mysqli_real_escape_string($connexion, $identifiant);

    $stmt = $connexion->prepare("
        SELECT * FROM tasks 
        WHERE identifiant = ?
        AND deadline BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 24 HOUR)
        AND status != 'Terminé'
        ORDER BY deadline ASC
    ");
    $stmt->bind_param("s", $safe_id);
    $stmt->execute();
    $donnees = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    echo json_encode($donnees);

    $stmt->close();
    mysqli_close($connexion);
?>