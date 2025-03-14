<?php
// 
require_once("block/header.php");
require_once("connectDB.php");

$pdo = connectDB();






if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $errors = [];
    $copyMail = [];

    $requete2 = $pdo->prepare("SELECT * FROM user WHERE Email = :Email;");
    $requete2->execute([
        "Email" => $_POST["Email"]
    ]);

    $mail = $requete2->fetch();




    $requete3 = $pdo->prepare("SELECT * FROM user WHERE username = :username;");
    $requete3->execute([
        "username" => $_POST["username"]
    ]);
    $username = $requete3->fetch();


    if (empty($_POST["Email"])) {
        $errors["Email"] = "L'email est vide";
    }


    if (empty($_POST["username"])) {
        $errors["username"] = "Le username est vide";
    }

    if ($mail != false) {
        $errors["Email"] = " Le mail existe déja !";
    }

    if ($username != false) {
        $errors["username"] = "Le username existe déja !";
    }



    if (strlen($_POST["password"]) < 8) {
        $errors["password"] = "le mot de passe est trop court !";
    }

    if (empty($_POST["password"])) {
        $errors["password"] = "Le mot de passe est vide";
    }



    if (!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
        $errors["Email"] = " Le mail est invalide";
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
        // header("Location: admin.php");
    }
}

?>

<form method="POST" action="inscription.php">

    <span class="d-block p-2 text-bg-dark">

        <label for="Email">Email</label>
        <input type="Email" name="Email">

        <?php if (isset($errors["Email"])) {
            echo ($errors["Email"]);
        } ?>

    </span>

    <span class="d-block p-2 text-bg-dark">

        <label for="Username">Username</label>
        <input type="text" name="username">

        <?php if (isset($errors["username"])) {
            echo ($errors["username"]);
        } ?>

    </span>

    <span class="d-block p-2 text-bg-dark">

        <label for="password">Mot de passe</label>
        <input type="password" name="password">

        <?php if (isset($errors["password"])) {
            echo ($errors["password"]);
        } ?>

    </span>
    <span class="d-block p-2 text-bg-dark">

        <button>Valider</button>
        <button formaction="index.php">Annuler</button>

    </span>

</form>

<a href="login.php">Se connecter</a>