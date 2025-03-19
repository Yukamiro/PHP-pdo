<?php
require_once("block/header.php");
require_once("UserManager.php");



if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (empty($_POST["email"])) {
        $errors["email"] = "L'email est vide";
    }

    if (empty($errors)) {

        $userManager = new UserManager();

        $userManager->selectUserByEmail($_POST["email"]);
    }
}

?>
<div class="container text-center">
    <div class="row align-items-start">
        <div class="col" style="padding-top: 20%;">
            Entrez votre adresse mail

            <form method="POST" action="forget.php">

                <label for="email">Email</label>
                <input type="email" name="email">

                <?php if (isset($errors["email"])) {
                    echo ($errors["email"]);
                } ?>

                <button>Envoyer</button>

            </form>

            <a href="login.php">Connexion</a>
        </div>
    </div>
</div>