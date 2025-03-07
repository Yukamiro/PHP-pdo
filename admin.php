<?php
require_once("block/header.php");
require_once("connectDB.php");
session_start();
var_dump($_SESSION["username"]);

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
}



$pdo = connectDB();


$requete = $pdo->prepare("SELECT * FROM car;");
$requete->execute();
$cars = $requete->fetchAll();
var_dump($cars);
?>
<a href="logout.php">Se deconnecter</a>

<a href="add.php"> Ajouter une voiture</a>
<?php

foreach ($cars as $car) {  ?>

    <div class="dog">
        <img src="img/<?php echo ($car["image"]) ?>" alt="Model de la voiture">
        <h2><?php echo ($car["model"]) ?></h2>
        <p><?php echo ($car["brand"]) ?></p>
        <p><?php echo ($car["horsePower"]) ?></p>
        <a href="update.php?id=<?php echo ($car["id"]) ?>">Modifier</a>
        <a href="delete.php?id=<?php echo ($car["id"]) ?>">Supprimer</a>


    </div>

<?php
}
?>

<a href="logout.php">Se déconnecter</a>