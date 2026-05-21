<?php
    header('Content-Type: application/json');
    session_start();
    $connexion = mysqli_connect("inf-mysql.univ-rouen.fr", "beaucart", "23052003", "beaucart2");

    if (!isset($_SESSION['hasLogged'])) {
        echo json_encode(["success" => false, "error" => "Non connecté"]);
        exit;
    }
    $id = $_SESSION['id'];

    $request = "DELETE FROM accounts WHERE identifiant = ?";
    $stmt = mysqli_prepare($connexion, $request);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $request = "DELETE FROM tasks WHERE identifiant = ?";
    $stmt = mysqli_prepare($connexion, $request);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $request = "DELETE FROM category WHERE identifiant = ?";
    $stmt = mysqli_prepare($connexion, $request);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    echo json_encode(["success" => true]);

    unset($_SESSION['id']);
    unset($_SESSION['hasLogged']);

    $stmt->close();
    mysqli_close($connexion);
?>