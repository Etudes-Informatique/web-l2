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
    <header>
        <h1>Tableau de bord</h1>
        <div id="user-info" data-id="<?php echo htmlspecialchars($user_id); ?>"></div>
        <nav>
            <a href="../index.php">Accueil</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>Mes Catégories</h2>
            <form action="dashboard.php" method="get" id="formulaire">
                <p><input type="submit" value="Voir mes Tâches" id="dashboard"></p>
            </form>
            <div id="category-create"></div>
            <div id="categories-container"></div>
        </section>
    </main>
</body>
</html>