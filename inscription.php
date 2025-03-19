<?php
// 
require_once("block/header.php");
require_once("UserManager.php");






if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $errors = [];

    var_dump($_POST["email"]);
    $userManager = new UserManager();



    $errors = $userManager->verifyError($errors, $_POST);


    if (empty($errors)) {

        $emailExist = $userManager->selectUserByEmail($_POST["email"]);

        $usernameExist = $userManager->selectUserByUsername($_POST["username"]);

        if ($emailExist != false) {
            $errors["email"] = " Le mail existe déja !";
        }

        if ($usernameExist != false) {
            $errors["username"] = "Le username existe déja !";
        }
        if (empty($errors)) {

            $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);


            $user = new User(null, $_POST["username"], $pass, $_POST["email"]);
            $userManager->insertUser($user);

            session_start();
            $_SESSION["username"] = $user->getUsername();
            header("Location: admin.php");
        }
    }
}

?>

<form method="POST" action="inscription.php">

    <span class="d-block p-2 text-bg-dark">

        <label for="email">Email</label>
        <input type="email" name="email">

        <?php if (isset($errors["email"])) {
            echo ($errors["email"]);
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