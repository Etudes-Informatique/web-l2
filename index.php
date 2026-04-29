<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="css/main.css"/>
</head>
<body>
    <?php session_start(); ?>

    <?php if (isset($_SESSION['hasLogged'])) : ?>
        <p>
            <a href="./php/dashboard.php" class="btn">Accéder à mes Tâches</a>
        </p>
            
            <form action="./php/logout.php" method="get" id="log_off">
                <p><input type="submit" value="Se Déconnecter" id="logout"></p>
            </form>
        </div>

    <?php else : ?>
        <div id="homeMain">
            <h1>Organise tes tâches simplement. Gagne du temps, reste focus.</h1>
            <p>Une plateforme intuitive pour gérer tes projets.</p>
            <form action="./HTML/login.html" method="get" id="formulaire">
                <p><input type="submit" value="Commencer ➜" id="Connect"></p>
            </form>
            <p id="createAccount">Pas encore inscrit ? <a href="./html/register.html">Crée un compte</a></p>
        </div>
    <?php endif; ?>
</body>
</html>