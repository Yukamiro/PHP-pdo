<?php
require_once("block/header.php");
require_once("connectDB.php");
var_dump($_GET);

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}



if ($_SERVER['REQUEST_METHOD'] === "POST") {
    var_dump("ok");
    $errors = [];
    if (empty($_POST["model"])) {
        $errors["model"] = "Le model est vide";
    }
    if (empty($_POST["brand"])) {
        $errors["brand"] = "Le brand est vide";
    }
    if (empty($_POST["horsePower"])) {
        $errors["horsePower"] = "La vitesse est vide";
    }
    if (empty($_POST["image"])) {
        $errors["image"] = "L'image est vide";
    }
    if ($_POST["horsePower"] <= 0 and $_POST["horsePower"] >= 800) {
        $vitesse["horsePower"] = "La vitesse dois être comprise entre 0 et 800";
    }

    if (empty($errors) and empty($vitesse)) {
        $pdo = connectDB();
        $requete = $pdo->prepare("INSERT INTO car(model, brand, horsePower, image)
                        VALUES(:model, :brand, :horsePower, :image);");
        $requete->execute([
            "model" => $_POST["model"],
            "brand" => $_POST["brand"],
            "horsePower" => $_POST["horsePower"],
            "image" => $_POST["image"],
        ]);
        header("location: admin.php");
    }
}
?>


<form method="POST" action="add.php">

    <label for="model">model</label>
    <input type="text" id="model" name="model">
    <?php if (isset($errors["model"])) {
        echo ($errors["model"]);
    } ?>


    <label for="brand">brand</label>
    <input type="text" id="brand" name="brand">

    <?php if (isset($errors["brand"])) {
        echo ($errors["brand"]);
    } ?>

    <label for="horsePower">horsePower</label>
    <input type="number" id="horsePower" name="horsePower">

    <?php if (isset($errors["horsePower"])) {
        echo ($errors["horsePower"]);
    } ?>

    <?php if (isset($vitesse["horsePower"])) {
        echo ($vitesse["horsePower"]);
    } ?>


    <label for="image">image</label>
    <input type="file" id="image" name="image">

    <?php if (isset($errors["horsePower"])) {
        echo ($errors["horsePower"]);
    } ?>


    <label for="submit"></label>
    <input type="submit" value="Valider">



</form>