<?php
require_once("block/header.php");
require_once("CarManager.php");


session_start();


if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}




$CarManager = new CarManager();

$cars = $CarManager->selectAllCars();

?>
<div class="p-3 mb-2 bg-dark-subtle text-dark-emphasis">
    <div class="container text-center" style="padding: 2em;">
        <div class="row align-items-start">

            <div class="col">
                <a href="logout.php" class="text-danger" class="navbar-brand">Se deconnecter</a>
            </div>

            <div class="col">
                <a href="add.php" class="text-success" class="navbar-brand"> Ajouter une voiture</a>
            </div>

        </div>
    </div>
</div>

<div class="container text-center">
    <div class="d-flex justify-content-evenly" style="padding-top: 1em;">
        <?php
        foreach ($cars as $car) {  ?>
            <div class="col">
                <img src="img/<?php echo ($car->getImage()) ?>" style="width: 50%;" alt="Model de la voiture">
                <h2><?php echo ($car->getModel()) ?></h2>
                <p><?php echo ($car->getBrand()) ?></p>
                <p><?php echo ($car->getHorsePower()) ?> Chevaux</p>
                <a href="update.php?id=<?php echo ($car->getId()) ?>">Modifier</a>
                <a href="delete.php?id=<?php echo ($car->getId()) ?>" class="text-danger">Supprimer</a>
            </div>


        <?php
        }
        ?>
    </div>
</div>