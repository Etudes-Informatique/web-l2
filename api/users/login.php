<?php
function gotError($connexion) {
        echo mysqli_error($connexion);
        echo "<p id='mysql_error'>Une erreur s'est produite durant votre inscription, veuillez contacter l'administrateur.</p>";
        echo "<button onclick=\"window.location.href='../html/register.html'\">Réessayer</button>";
        exit;        
    }

    function errorLogin() {
        echo "<p id='mysql_error'>Identifiant ou mot de passe incorrect.</p>";
        echo "<button onclick=\"window.location.href='../html/login.html'\">Réessayer</button>";
        exit;    
    }

    $identifiant = $_POST['identifiant'];
    $password = $_POST['password'];

    $connexion = mysqli_connect("inf-mysql.univ-rouen.fr", "beaucart", "23052003", "beaucart2");

    if (!$connexion) {
        gotError($connexion);
    }

    $request = "SELECT * FROM accounts WHERE identifiant = ?";
    $stmt = mysqli_prepare($connexion, $request);
    mysqli_stmt_bind_param($stmt, "s", $identifiant);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        errorLogin();
    }

    $user = mysqli_fetch_assoc($result);

    if (!password_verify($password, $user['password'])) {
        errorLogin();
    }
    
    session_start();
    $_SESSION['hasLogged'] = true;
    $_SESSION['id'] = $identifiant;
    echo "Vous êtes connecté !";
    echo "<button onclick=\"window.location.href=../../index.php'\">Menu Principal</button>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Connexion</title>
</head>
<body>
    <script>
        alert("Vous êtes connecté ! Retour au menu principal");
        window.location.href = "../../index.php";
    </script>
</body>
</html>