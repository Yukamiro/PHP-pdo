<?php
require_once("block/header.php");
require_once("connectDB.php");
var_dump($_GET["id"]);

$pdo = connectDB();
$requete2 = $pdo->prepare("SELECT * FROM car WHERE id = :id;");
$requete2->execute([
    ":id" => $_GET["id"]
]);

$car = $requete2->fetch();
var_dump($car);

if (!isset($_GET["id"])) {
    header("location: admin.php");
}

if ($_GET["id"] == null || $_GET["id"] != $car["id"]) {
    header("location: admin.php");
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (!isset($_GET["idd"])) {
        header("location: admin.php");
    }


    $requete = $pdo->prepare("DELETE FROM car WHERE id = :id;");
    $requete->execute([
        "id" => $_GET["id"]
    ]);
}
?>

<form method="POST" action="delete.php?id=<?php echo ($_GET["id"]) ?>">
    <button>Supprimer</button>
    <button formaction="admin.php">Annuler</button>
</form>