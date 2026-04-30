<?php 
    function gotError() {
        echo mysqli_error($connexion);
        echo "<p id='mysql_error'>Une erreur c'est produite durant votre inscription, veillez contacter l'administrateur.</p>";
        echo "<button onclick=\"window.location.href='../html/register.html'\">Re-essayer</button>";
        exit;
    }

    function userAlreadyExist() {
        echo "<p id='mysql_error'>Un utilisateur avec cette identifiant existe déjà.</p>";
        echo "<button onclick=\"window.location.href='../html/register.html'\">Re-essayer</button>";
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
            echo "string < 8\n";
            return false;
        }
        if (!containtUpperCase($pwd)) {
            echo "No upper case char\n";
            return false;
        }
        if (!containtSpecialCaracter($pwd)) {
            echo "No special char\n";
            return false;
        }
        return true;
    }

    $identifiant = $_GET['identifiant'];
    $password = $_GET['password'];
    $cpassword = $_GET['cpassword'];
    if (!$identifiant || !$password || !$cpassword) {
        echo "<p>Des informations sont manquantes, votre inscription n'a pas pu être finalisée.</p>";
        echo "<button onclick=\"window.location.href='../html/register.html'\">Re-essayer</button>";
        exit;
    } 
    if ($password != $cpassword) {
        echo "<p id='pwd_diff_register'>Les mots de passes ne correspondent pas, veillez ré-essayer.</p>";
        echo "<button onclick=\"window.location.href='../html/register.html'\">Re-essayer</button>";
        exit;
    }
    if (!pwdRespectCondition($password)) {
        echo "<p id='pwd_no_condition'>Le mot de passe doit faire minimum 8 caractères, avec une majuscule et un caractère spéciale</p>";
        echo "<button onclick=\"window.location.href='../html/register.html'\">Re-essayer</button>";
        exit;
    }

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
    echo "<p>Votre compte a été crée avec succès ! Vous pouvez désormais vous connecter !</p>";
    echo "<button onclick=\"window.location.href='../html/login.html'\">Allez se connecter</button>";
    exit;
?>