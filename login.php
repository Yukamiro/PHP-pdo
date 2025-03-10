<?php
require_once("block/header.php");
require_once("connectDB.php");

$pdo = connectDB();
$pass = password_hash("admin", PASSWORD_DEFAULT);
var_dump($pass);
var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $errors = [];
    // vérifier si POST["username"] existe
    $requete = $pdo->prepare("SELECT * FROM user WHERE username = :username;");
    $requete->execute([
        "username" => $_POST["username"],
    ]);
    $user = $requete->fetch();

    var_dump($user);


    if ($user == false || empty($_POST["username"]) || empty($_POST["password"])) {
        $errors["user"] = "Le username ou le mot de passe est invalide";
    }



    if (empty($errors)) {

        if (password_verify($_POST["password"], $user["password"])) {
            session_start();
            $_SESSION["username"] = $user["username"];
            header("Location: admin.php");
        } else {
            var_dump("pas ok");
        }
    }
}

if (isset($errors["user"])) {
    echo ($errors["user"]);
} ?>

<form method="POST" action="login.php">

    <label>Username</label>
    <input type="text" name="username">

    <label>Mot de passe</label>
    <input type="password" name="password">

    <button>Valider</button>


</form>
<a href="inscription.php">S'inscrire</a>
<a href="forget.php">Mot de passe oublié</a>

<!-- mdp de username 2 : $2y$10$7M09EwTgziusIZ.oeq2r6OJWpbp5OZuzDhPGdhyKkrrXyAJHm22v2 -->