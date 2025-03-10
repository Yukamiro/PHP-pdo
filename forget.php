<?php
require_once("block/header.php");
require_once("connectDB.php");
var_dump($_POST);
var_dump($_GET);
$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (empty($_POST["Email"])) {
        $errors["Email"] = "L'email est vide";
    }

    if (empty($errors)) {

        $requete = $pdo->prepare("SELECT * FROM user WHERE Email = :Email;");
        $requete->execute([
            "Email" => $_POST["Email"]
        ]);

        $email = $requete->fetch();

        var_dump($email);
    }
}

?>

Entrez votre adresse mail

<form method="POST" action="forget.php">

    <label for="Email">Email</label>
    <input type="Email" name="Email">

    <?php if (isset($errors["Email"])) {
        echo ($errors["Email"]);
    } ?>

    <button>Envoyer</button>

</form>

<a href="login.php">Connexion</a>