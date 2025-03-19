<?php
require_once("block/header.php");
require_once("CarManager.php");





if ($_SERVER['REQUEST_METHOD'] === "POST") {


    $carManager = new CarManager();
    $car = $carManager->selectCarByID($_GET["id"]);


    if (!isset($_GET["id"])) {
        header("location: admin.php");
    }

    if ($_GET["id"] == null || $_GET["id"] != $car->getId()) {
        header("location: admin.php");
    }

    $carManager->deleteCarByID($_GET["id"]);
    header("location: admin.php");
    exit();
}
?>
<div>
    <h2>
        ON SUPPRIME CE TRUC LA ?
    </h2>
</div>

<form method="POST" action="delete.php?id=<?php echo ($_GET["id"]) ?>">

    <p>
        <button class="p-3 mb-2 bg-danger text-white">Supprimer</button>
    </p>

    <p>
        <button formaction="admin.php" class="p-3 mb-2 bg-danger-subtle text-danger-emphasis">Annuler</button>
    </p>
</form>