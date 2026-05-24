<?php
    session_start();
    if (!isset($_SESSION['hasLogged'])) {
        header('Location: ../index.php');
        exit();
    }
    $user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="../js/show_categories.js" defer></script>
    <script src="../js/create_category.js" defer></script>
</head>
<body>
    <header id="head">
        <div id="logo">
            <a href="../index.php"><img src="../img/logo.png" alt="TaskManager"></a>
        </div>
        <div id="headBoutons">
            <a href="../index.php" id="profil">Accueil</a>
            <a href="../api/users/logout.php" id="log_off">Se déconnecter<img src="../img/se-deconnecter.png" alt="Logout"></a>
        </div>
    </header>
    <main>
        <div id="homeMain">
            <h1>Tableau de bord</h1>
            <p>Mes Catégories</p>
            <form action="dashboard.php" method="get" id="formulaire">
                <p><input type="submit" value="Voir mes Tâches" id="dashboard"></p>
            </form>
            <div id="category-create"></div>
            <div id="categories-container"></div>
        </div>
    </main>
</body>
</html>