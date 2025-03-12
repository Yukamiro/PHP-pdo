<?php
require_once("block/header.php");
require_once("connectDB.php");


$pdo = connectDB();


$requete = $pdo->prepare("SELECT * FROM car;");
$requete->execute();
$cars = $requete->fetchAll();

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
        foreach ($cars as $car) {  ?>
            <div class="col">
                <img src="img/<?php echo ($car["image"]) ?>" style="width: 50%;" alt="Model de la voiture">
                <h2><?php echo ($car["model"]) ?></h2>
                <p><?php echo ($car["brand"]) ?></p>
                <p><?php echo ($car["horsePower"]) ?> Chevaux</p>

            </div>


        <?php
        }
        ?>
    </div>
</div>