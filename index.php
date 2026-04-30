<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Accueil</title>
    <link rel="stylesheet" href="css/main.css"/>
</head>
<body>
    <?php session_start(); ?>

    <?php if (isset($_SESSION['hasLogged'])) : ?>
        <header id="head">
            <div id="logo">
                <a href="index.php"><img src="img/logo.png" alt="TaskManager"></a>
            </div>
            <div id="headBoutons">
                <a href="./api/users/logout.php" id="log_off">Se déconnecter<img src="img/se-deconnecter.png" alt="Logout"></a>
                <a href="./php/profil.php" id="show_profil">Profil</a>
            </div>
        </header>
        <div id="homeMain">
            <h1>Bienvenue 👋</h1>
            <p>Ton espace est prêt. Commence à organiser tes tâches dès maintenant.</p>
            <form action="./php/dashboard.php" method="get" id="formulaire">
                <p><input type="submit" value="Accéder à mes Tâches ➜" id="Connect"></p>
            </form>
        </div>
        

    <?php else : ?>
        <header id="head">
            <div id="logo">
                <a href="index.php"><img src="img/logo.png" alt="TaskManager"></a>
            </div>
            <div id="headBoutons">
                <a href="./html/login.html" id="headConnect">Se connecter</a>
                <a href="./html/register.html" id="headRegister">S'inscrire</a>
            </div>
        </header>
        <div id="homeMain">
            <h1>Organise tes tâches simplement. Gagne du temps, reste focus.</h1>
            <p>Une plateforme intuitive pour gérer tes projets.</p>
            <form action="./html/login.html" method="get" id="formulaire">
                <p><input type="submit" value="Commencer ➜" id="Connect"></p>
            </form>
            <p id="createAccount">Pas encore inscrit ? <a href="./html/register.html">Crée un compte</a></p>
        </div>
    <?php endif; ?>
</body>
</html>