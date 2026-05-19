<?php
    header('Content-Type: application/json');
    
    $connexion = mysqli_connect("localhost", "root", "", "task_manager");
    
    if (!$connexion) {
        echo json_encode(["success" => false, "error" => "Échec de la connexion : " . mysqli_connect_error()]);
        exit;
    }


    $search = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';

    if (strlen($search) < 2) {
        echo json_encode([]);
        exit;
    }

    $searchTerm = "%" . $search . "%";

    $query = "SELECT * FROM tasks WHERE title LIKE ? OR description LIKE ? LIMIT 10";
    $stmt = $connexion->prepare($query);
    
    $stmt->bind_param("ss", $searchTerm, $searchTerm);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $tasks = [];

        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }

        echo json_encode($tasks);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    mysqli_close($connexion);
?>