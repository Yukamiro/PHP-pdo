<?php
require_once("block/header.php");
require_once("CarManager.php");

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}


$CarManager = new CarManager();

$cars = $CarManager->selectCarByID($_GET["id"]);

var_dump($cars);

if (!isset($_GET["id"])) {
    header("location: index.php");
}
if ($_GET["id"] == null || $_GET["id"] != $cars->getId()) {
    header("location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {


    $errors = [];

    $errors = $CarManager->verifyError($errors, $_POST);



    if (empty($errors)) {

        var_dump($errors);

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


                        unlink("img/" . $cars->getImage());



                        $cars->setModel($_POST["model"]);
                        $cars->setBrand($_POST["brand"]);
                        $cars->setHorsePower($_POST["horsePower"]);
                        $cars->setImage($image_url);

                        $CarManager->updateCarByID($cars);

                        echo "L'envoi a bien été effectué !";
                    } else {
                        echo ('J\'accepte que les jpg, jpeg, gif, png');
                    }
                } else {
                    echo ('le fichier est trop lourd 1MB max');
                }
            } else {
                echo ("L'image est vide");
            }
        }
    }
}


?>

<form method="POST" action="update.php?id=<?php echo ($_GET["id"]) ?>" enctype="multipart/form-data">
    <div class="d-flex flex-column mb-3">
        <div class="p-2">

            <label for="model"> modifier le model</label>
            <input type="text" id="model" name="model" value="<?php echo ($cars->getModel()) ?>">

            <?php if (isset($errors["model"])) {
                echo ($errors["model"]);
            } ?>

        </div>
        <div class="p-2">
            <label for="brand">modifier le brand</label>
            <input type="text" id="brand" name="brand" value="<?php echo ($cars->getBrand()) ?>">
            <?php if (isset($errors["brand"])) {
                echo ($errors["brand"]);
            } ?>
        </div>

        <div class="p-2">

            <label for="horsePower">modifie la VITESSE MON GROS</label>
            <input type="number" id="horsePower" name="horsePower" value="<?php echo ($cars->getHorsePower()) ?>">

            <?php if (isset($errors["horsePower"])) {
                echo ($errors["horsePower"]);
            } ?>


        </div>

        <div class="p-2">

            <label for="image">image</label>
            <input type="file" id="image" name="image" value="<?php echo ($cars->getImage()) ?>">

            <?php if (isset($errors["image"])) {
                echo ($errors["image"]);
            } ?>

        </div>

        <div class="p-2">

            <button type="button" class="btn btn-success">Confirmer</button>
            <input type="submit" value="Envoyer">


            <button formaction="admin.php" class="btn btn-danger">Annuler</button>

        </div>
    </div>

</form>