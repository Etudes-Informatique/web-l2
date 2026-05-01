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
    <script src="../js/show_task.js" defer></script>
    <script src="../js/create_task.js" defer></script>
    <script src="../js/create_category.js" defer></script>
    <script src="../js/edit_task.js" defer></script>
</head>
<body>
    <div id="user-info" data-id="<?php echo htmlspecialchars($user_id); ?>"></div>
    <header id="head">
        <div id="logo">
            <a href="index.php"><img src="../img/logo.png" alt="TaskManager"></a>
        </div>
        <div id="headBoutons">
            <a href="../index.php" id="profil">Accueil</a>
            <a href="../api/users/logout.php" id="log_off">Se déconnecter<img src="../img/se-deconnecter.png" alt="Logout"></a>
        </div>
    </header>
    <div id="homeMain">
            <h1>Tableau de bord</h1>
            <p>Mes taches</p>
            <form action="categoris.php" method="get" id="formulaire">
                <p><input type="submit" value="Gérer mes catégories ➜" id="Connect"></p>
            </form>
        </div>
    <main>
        <section>
            <h2>Mes Tâches</h2>
            <div id="tasks-create2"></div>
            <form action="categories.php" method="get" id="formulaire">
                <p><input type="submit" value="Gérer mes catégories" id="dashboard_categories"></p>
            </form>
            <div id="tasks-container"></div>
        </section>
    </main>
</body>
</html>