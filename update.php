<?php
require_once("block/header.php");
require_once("connectDB.php");


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
        $errors["horsePower"] .= "La vitesse est vide";
    }

    if ($_POST["horsePower"] <= 0 and $_POST["horsePower"] >= 800) {
        $errors["horsePower"] .= "La vitesse dois être comprise entre 0 et 800";
    }



    if (empty($errors)) {



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
    <div class="d-flex flex-column mb-3">
        <div class="p-2">

            <label for="model"> modifier le model</label>
            <input type="text" id="model" name="model" value="<?php echo ($car["model"]) ?>">

            <?php if (isset($errors["model"])) {
                echo ($errors["model"]);
            } ?>

        </div>
        <div class="p-2">
            <label for="brand">modifier le brand</label>
            <input type="text" id="brand" name="brand" value="<?php echo ($car["brand"]) ?>">

            <?php if (isset($errors["brand"])) {
                echo ($errors["brand"]);
            } ?>
        </div>

        <div class="p-2">

            <label for="horsePower">modifie la VITESSE MON GROS</label>
            <input type="number" id="horsePower" name="horsePower" value="<?php echo ($car["horsePower"]) ?>">

            <?php if (isset($errors["horsePower"])) {
                echo ($errors["horsePower"]);
            } ?>


        </div>

        <div class="p-2">

            <label for="image">image</label>
            <input type="file" id="image" name="image" value="<?php echo ($car["image"]) ?>">

            <?php if (isset($errors["image"])) {
                echo ($errors["image"]);
            } ?>

        </div>

        <div class="p-2">

            <button type="button" class="btn btn-success">Confirmer</button>

            <button formaction="admin.php" class="btn btn-danger">Annuler</button>

        </div>
    </div>

</form>

<?php

if (isset($valide)) {
    echo ($valide);
}
