<?php
require_once("block/header.php");

require_once("CarManager.php");





$CarManager = new CarManager();

$carObjects = $CarManager->selectAllCars();



?><div class="p-3 mb-2 bg-dark-subtle text-dark-emphasis">
    <div class="container text-center" style="padding: 2em;">
        <div class="row align-items-start">

            <div class="col">

                <a href="login.php" class="btn btn-success">Se connecter</a>

            </div>

        </div>
    </div>

</div>


<div class="container text-center">
    <div class="d-flex justify-content-evenly" style="padding-top: 1em;">
        <?php
        foreach ($carObjects as $carObject) {  ?>
            <div class="col">
                <img src="img/<?php echo ($carObject->getImage()) ?>" style="width: 50%;" alt="Model de la voiture">
                <h2><?php echo ($carObject->getModel()) ?></h2>
                <p><?php echo $carObject->getBrand() ?></p>
                <p><?php echo $carObject->getHorsePower() ?> Chevaux</p>

            </div>


        <?php
        }
        ?>
    </div>
</div>