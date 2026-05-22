<?php 
    function gotError() {
        echo mysqli_error($connexion);
        echo "<script>alert('Une erreur c'est produite durant votre inscription, veillez contacter l'administrateur.'); window.location.href = '../../html/register.html';</script>";
        exit;
    }

    function userAlreadyExist() {
        echo "<script>alert('Un utilisateur avec cette identifiant existe déjà.'); window.location.href = '../../html/register.html';</script>";
        exit;
    }

    function containtUpperCase($string) {
        $length = strlen($string);
        for ($i = 0; $i < $length; ++$i) {
            if (ctype_upper($string[$i])) {
                return true;
            }
        }
        return false;
    }

    function containtSpecialCaracter($string) {
        return preg_match('/[!@#$%^&*(),.?":{}|<>_\-\\[\]\/+=~`]/', $string) === 1;
    }

    function pwdRespectCondition($pwd) {
        if (strlen($pwd) < 8) {
            return false;
        }
        if (!containtUpperCase($pwd)) {
            return false;
        }
        if (!containtSpecialCaracter($pwd)) {
            return false;
        }
        return true;
    }

    $identifiant = $_GET['identifiant'];
    $password = $_GET['password'];
    $cpassword = $_GET['cpassword'];
    if (!$identifiant || !$password || !$cpassword) {
        echo "<script>alert('Des informations sont manquantes, votre inscription n'a pas pu être finalisée.'); window.location.href = '../../html/register.html';</script>";
        exit;
    } 
    if ($password != $cpassword) {
        echo "<script>alert('Les mots de passes ne correspondent pas.'); window.location.href = '../../html/register.html';</script>";
        exit;
    }
    if (!pwdRespectCondition($password)) {
        echo "<script>alert('Le mot de passe doit faire minimum 8 caractères, avec une majuscule et un caractère spéciale'); window.location.href = '../../html/register.html';</script>";
        exit;
    }

    $identifiant = strtolower($identifiant);

    $connexion = mysqli_connect("localhost", "root", "", "task_manager");
    $request = "SELECT * FROM accounts WHERE identifiant = '$identifiant';";
    $res = mysqli_query($connexion, $request);

    if (mysqli_num_rows($res) != 0) {
        userAlreadyExist();
    }
    
    $hpassword = password_hash($password, PASSWORD_DEFAULT);
    $request = "INSERT INTO accounts (identifiant, password) VALUES ('$identifiant', '$hpassword')";
    $res = mysqli_query($connexion, $request);
    if (!$res) {
        gotError();
    }
    echo "<script>alert('Votre compte a été crée avec succès ! Vous pouvez désormais vous connecter !'); window.location.href = '../../html/login.html';</script>";
    
    exit;

    mysqli_close($connexion);
?>