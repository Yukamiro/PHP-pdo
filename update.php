<?php
require_once("block/header.php");
require_once("connectDB.php");
var_dump($_GET);
var_dump($_POST);
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}



$pdo = connectDB();
$requete2 = $pdo->prepare("SELECT * FROM car WHERE id = :id;");
$requete2->execute([
    ":id" => $_GET["id"]
]);
$car = $requete2->fetch();
var_dump($car);


if (!isset($_GET["id"])) {
    header("location: index.php");
}
if ($_GET["id"] == null || $_GET["id"] != $car["id"]) {
    header("location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $errors = [];
    if (empty($_POST["model"])) {
        $errors["model"] = "Le model est vide";
    }
    if (empty($_POST["brand"])) {
        $errors["brand"] = "Le brand est vide";
    }
    if (empty($_POST["horsePower"])) {
        $vitesse["horsePower"] = "La vitesse est vide";
    }

    if ($_POST["horsePower"] <= 0 and $_POST["horsePower"] >= 800) {
        $errors["horsePower"] = "La vitesse dois être comprise entre 0 et 800";
    }

    if (empty($_POST["image"])) {
        $errors["image"] = "L'image est vide";
    }

    if (empty($errors) and empty($vitesse)) {

        if (!isset($_GET["id"])) {
            header("location: index.php");
        }

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


?>

<form method="POST" action="update.php?id=<?php echo ($_GET["id"]) ?>">

    <label for="model"> modifier le model</label>
    <input type="text" id="model" name="model" value="<?php echo ($car["model"]) ?>">

    <?php if (isset($errors["model"])) {
        echo ($errors["model"]);
    } ?>

    <label for="brand">modifier le brand</label>
    <input type="text" id="brand" name="brand" value="<?php echo ($car["brand"]) ?>">

    <?php if (isset($errors["brand"])) {
        echo ($errors["brand"]);
    } ?>

    <label for="horsePower">modifier la je sais pas</label>
    <input type="number" id="horsePower" name="horsePower" value="<?php echo ($car["horsePower"]) ?>">

    <?php if (isset($errors["horsePower"])) {
        echo ($errors["horsePower"]);
    } ?>

    <?php if (isset($vitesse["horsePower"])) {
        echo ($vitesse["horsePower"]);
    } ?>


    <label for="image">image</label>
    <input type="file" id="image" name="image" value="<?php echo ($car["image"]) ?>">

    <?php if (isset($errors["image"])) {
        echo ($errors["image"]);
    } ?>

    <label for="submit"></label>
    <input type="submit" value="confirmer">



</form>