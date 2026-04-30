<?php
    header('Content-Type: application/json');
    $connexion = mysqli_connect("inf-mysql.univ-rouen.fr", "beaucart", "23052003", "beaucart2");

    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];
    $deadline = !empty($_POST['deadline']) ? $_POST['deadline'] : null;

    $query = "UPDATE tasks SET title=?, description=?, priority=?, status=?, deadline=? WHERE id=?";
    $stmt = $connexion->prepare($query);
    $stmt->bind_param("sssssi", $title, $description, $priority, $status, $deadline, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }
?>