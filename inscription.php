<?php
// 
require_once("block/header.php");
require_once("connectDB.php");

$pdo = connectDB();


var_dump($_POST);



if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $errors = [];
    $copyMail = [];

    $requete2 = $pdo->prepare("SELECT * FROM user WHERE Email = :Email;");
    $requete2->execute([
        "Email" => $_POST["Email"]
    ]);

    $mail = $requete2->fetch();

    var_dump($mail);


    $requete3 = $pdo->prepare("SELECT * FROM user WHERE username = :username;");
    $requete3->execute([
        "username" => $_POST["username"]
    ]);
    $username = $requete3->fetch();
    var_dump($username);

    if ($mail != false) {
        $errors["Email"] = "Le mail existe déja !";
    }

    if ($username != false) {
        $errors["username"] = "Le username existe déja !";
    }


    if (empty($_POST["Email"])) {
        $errors["Email"] = "L'email est vide";
    }


    if (empty($_POST["username"])) {
        $errors["username"] = "Le username est vide";
    }

    if (strlen($_POST["password"]) < 8) {
        $errors["password"] = "le mot de passe est trop court !";
    }

    if (empty($_POST["password"])) {
        $errors["password"] = "Le mot de passe est vide";
    }






    if (empty($errors)) {

        $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $requete = $pdo->prepare("INSERT INTO user(username, password, Email)
                        VALUES(:username, :password, :Email);");
        $requete->execute([
            "username" => $_POST["username"],
            "password" => $pass,
            "Email" => $_POST["Email"],
        ]);
        $username = $requete->fetch();

        session_start();
        $_SESSION["username"] = $_POST["username"];
        header("Location: admin.php");
    }
}

?>

<form method="POST" action="inscription.php">

    <label for="Email">Email</label>
    <input type="Email" name="Email">

    <?php if (isset($errors["Email"])) {
        echo ($errors["Email"]);
    } ?>

    <label for="Username">Username</label>
    <input type="text" name="username">

    <?php if (isset($errors["username"])) {
        echo ($errors["username"]);
    } ?>

    <label for="password">Mot de passe</label>
    <input type="password" name="password">

    <?php if (isset($errors["password"])) {
        echo ($errors["password"]);
    } ?>

    <button>Valider</button>


</form>

<a href="login.php">Se connecter</a>