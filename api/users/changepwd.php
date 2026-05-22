<?php
    header('Content-Type: application/json');
    session_start();

    $connexion = mysqli_connect("localhost", "root", "", "task_manager");

    if (!isset($_SESSION['hasLogged'])) {
        echo json_encode(["success" => false, "error" => "Non connecté"]);
        exit;
    }

    function containtUpperCase($string) {
        $length = strlen($string);
        for ($i = 0; $i < $length; ++$i) {
            if (ctype_upper($string[$i])) return true;
        }
        return false;
    }

    function containtSpecialCaracter($string) {
        return preg_match('/[!@#$%^&*(),.?":{}|<>_\-\\[\]\/+=~`]/', $string) === 1;
    }

    function pwdRespectCondition($pwd) {
        if (strlen($pwd) < 8) return false; 
        if (!containtUpperCase($pwd)) return false;
        if (!containtSpecialCaracter($pwd)) return false;
        return true;
    }

    $password  = $_POST['password']  ?? null;
    $cpassword = $_POST['cpassword'] ?? null;
    $id        = $_POST['id']        ?? null;

    if (empty($password) || empty($cpassword)) {
        echo json_encode(["success" => false, "error" => "Champs vides."]); 
        exit;
    }

    if ($password != $cpassword) {
        echo json_encode(["success" => false, "error" => "Les deux mots de passe sont différents."]);
        exit;
    }

    if (!pwdRespectCondition($password)) {
        echo json_encode(["success" => false, "error" => "Le mot de passe ne respecte pas les conditions."]); 
        exit;
    }

    $id = strtolower($id);
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $connexion->prepare("UPDATE accounts SET password = ? WHERE identifiant = ?");
    $stmt->bind_param("ss", $hashed, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Erreur base de données."]);
    }

    $stmt->close();
    mysqli_close($connexion);
?>