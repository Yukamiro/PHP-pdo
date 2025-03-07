<?php
require_once("block/header.php");
require_once("connectDB.php");
var_dump($_POST);
var_dump($_GET);

$pdo = connectDB();


$requete = $pdo->prepare("SELECT * FROM car;");
$requete->execute();
$cars = $requete->fetchAll();
var_dump($cars);
?>
<a href="add.php"> Ajouter une voiture</a>
<?php

foreach ($cars as $car) {  ?>

    <div class="dog">
        <img src="img/<?php echo ($car["image"]) ?>" alt="Model de la voiture">
        <h2><?php echo ($car["model"]) ?></h2>
        <p><?php echo ($car["brand"]) ?></p>
        <p><?php echo ($car["horsePower"]) ?></p>
        <a href="update.php?id=<?php echo ($car["id"]) ?>">Modifier</a>


    </div>

<?php
}
?>