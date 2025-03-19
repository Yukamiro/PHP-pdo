<?php
require_once("block/header.php");
require_once("CarManager.php");




session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}



if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $errors = [];

    $CarManager = new CarManager();

    $errors = $CarManager->verifyError($errors, $_POST);

    var_dump($errors);

    if (empty($errors)) {

        if ($_FILES['image']['error'] == 0) {


            // Etape 2
            if ($_FILES['image']['size'] <= 10000000000) {
                //Etape 3

                $extensions_autorisees = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
                $extension = $_FILES['image']['type'];
                if (in_array($extension, $extensions_autorisees)) {
                    //Etape 4
                    $image_url = uniqid() . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $image_url);

                    $car = new Car(null, $_POST["brand"], $_POST["model"], $_POST["horsePower"], $image_url);

                    $CarManager->insertCar($car);




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
?>


<form method="POST" action="add.php" enctype="multipart/form-data">
    <div class="d-flex flex-column mb-3">

        <div class="p-2">

            <label for="model">model</label>
            <input type="text" id="model" name="model">
            <?php if (isset($errors["model"])) {
                echo ($errors["model"]);
            } ?>

        </div>

        <div class="p-2">

            <label for="brand">brand</label>
            <input type="text" id="brand" name="brand">

            <?php if (isset($errors["brand"])) {
                echo ($errors["brand"]);
            } ?>

        </div>

        <div class="p-2">

            <label for="horsePower">horsePower</label>
            <input type="number" id="horsePower" name="horsePower">

            <?php if (isset($errors["horsePower"])) {
                echo ($errors["horsePower"]);
            } ?>

        </div>

        <div class="p-2">

            <label for="image">image</label>
            <input type="file" id="image" name="image">

            <?php if (isset($errors["image"])) {
                echo ($errors["image"]);
            } ?>

        </div>

        <div class=" p-2">

            <button>Confirmer</button>
            <button formaction="admin.php">Annuler</button>

        </div>
    </div>

</form>