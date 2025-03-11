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



    if (empty($errors) and empty($vitesse)) {



        if (!isset($_GET["id"])) {
            header("location: index.php");
        }

        if (isset($_FILES["image"])) {
            if ($_FILES['image']['error'] == 0) {


                // Etape 2
                if ($_FILES['image']['size'] <= 100000000) {
                    //Etape 3

                    $extensions_autorisees = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
                    $extension = $_FILES['image']['type'];
                    if (in_array($extension, $extensions_autorisees)) {
                        //Etape 4
                        $image_url = uniqid() . $_FILES['image']['name'];
                        move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $image_url);

                        unlink("img/" . $car["image"]);

                        $requete = $pdo->prepare("UPDATE car SET model = :model, brand = :brand, horsePower = :horsePower, image = :image WHERE id = :id;");
                        $requete->execute([
                            ":model" => $_POST["model"],
                            ":brand" => $_POST["brand"],
                            ":horsePower" => $_POST["horsePower"],
                            ":image" => $image_url,
                            ":id" => $car["id"]
                        ]);


                        echo "L'envoi a bien été effectué !";
                    } else {
                        echo ('J\'accepte que les jpg, jpeg, gif, png');
                    }
                } else {
                    echo ('le fichier est trop lourd 1MB max');
                }
            }
        }
    }
}


?>

<form method="POST" action="update.php?id=<?php echo ($_GET["id"]) ?>" enctype="multipart/form-data">

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

    <button formaction="admin.php">Annuler</button>


</form>

<?php

if (isset($valide)) {
    echo ($valide);
}
