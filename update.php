<?php
require_once("block/header.php");
require_once("connectDB.php");
var_dump($_GET);
var_dump($_POST);



if ($_SERVER['REQUEST_METHOD'] === "POST") {

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
    if (empty($errors)) {

        $pdo = connectDB();
        $requete2 = $pdo->prepare("SELECT * FROM car WHERE id = :id;");
        $requete2->execute([
            ":id" => 47
        ]);
        $car = $requete2->fetch();
        var_dump($car);
        $requete = $pdo->prepare("UPDATE car SET model = :model, brand = :brand, horsePower = :horsePower, image = :image WHERE id = :id;");
        $requete->execute([
            ":model" => $_POST["model"],
            ":brand" => $_POST["brand"],
            ":horsePower" => $_POST["horsePower"],
            ":image" => $_POST["image"],
            ":id" => $car["id"]
        ]);
    }
}

if (!isset($_GET["id"])) {
    header("location: index.php");
}

?>

<form method="POST" action="update.php?id=47">

    <label for="model"> modifier le model</label>
    <input type="text" id="model" name="model">

    <?php if (isset($errors["model"])) {
        echo ($errors["model"]);
    } ?>

    <label for="brand">modifier le brand</label>
    <input type="text" id="brand" name="brand">

    <?php if (isset($errors["brand"])) {
        echo ($errors["brand"]);
    } ?>

    <label for="horsePower">modifier la je sais pas</label>
    <input type="number" id="horsePower" name="horsePower">

    <?php if (isset($errors["horsePower"])) {
        echo ($errors["horsePower"]);
    } ?>

    <label for="image">image</label>
    <input type="text" id="image" name="image">

    <?php if (isset($errors["image"])) {
        echo ($errors["image"]);
    } ?>

    <label for="submit"></label>
    <input type="submit" value="confirmer">



</form>