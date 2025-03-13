<?php
require_once("block/header.php");
require_once("connectDB.php");

$pdo = connectDB();
$pass = password_hash("admin", PASSWORD_DEFAULT);


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $errors = [];
    // vérifier si POST["username"] existe
    $requete = $pdo->prepare("SELECT * FROM user WHERE username = :username;");
    $requete->execute([
        "username" => $_POST["username"],
    ]);
    $user = $requete->fetch();




    if ($user == false || empty($_POST["username"]) || empty($_POST["password"])) {
        $errors["user"] = "Le username ou le mot de passe est invalide";
    }



    if (empty($errors)) {

        if (password_verify($_POST["password"], $user["password"])) {
            session_start();
            $_SESSION["username"] = $user["username"];
            header("Location: admin.php");
        } else {
            $errors["password"] = "Le username ou le mot de passe est invalide";
        }
    }
}

if (isset($errors["user"])) {
?>
    <p class="text-danger">
    <?php
    echo ($errors["user"]);
} ?>
    </p>

    <form method="POST" action="login.php">
        <span class="d-block p-2 text-bg-dark">

            <label>Username</label>
            <input type="text" name="username">
        </span>
        <span class="d-block p-2 text-bg-dark">

            <label>Mot de passe</label>
            <input type="password" name="password">
        </span>

        <span class="d-block p-2 text-bg-dark">

            <button>Valider</button>
            <button formaction="index.php">Annuler</button>
        </span>

    </form>
    <div style="padding-left: 3em;">

        <a href="inscription.php">S'inscrire</a>
        <a href="forget.php" style="padding-left: 1em;">Mot de passe oublié</a>
    </div>

    <!-- mdp de username 2 : $2y$10$7M09EwTgziusIZ.oeq2r6OJWpbp5OZuzDhPGdhyKkrrXyAJHm22v2 -->