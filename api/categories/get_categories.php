<?php
    header('Content-Type: application/json');
    session_start();
    $connexion = mysqli_connect("inf-mysql.univ-rouen.fr", "beaucart", "23052003", "beaucart2");

    $response = ['success' => false, 'categories' => []];

    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        try {
            $stmt = $connexion->prepare("SELECT id, name AS title FROM category WHERE identifiant = ?");            
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $response['categories'] = $result->fetch_all(MYSQLI_ASSOC);
            $response['success'] = true;
        } catch (PDOException $e) {
            $response['error'] = $e->getMessage();
        }
    }

    echo json_encode($response);
?>