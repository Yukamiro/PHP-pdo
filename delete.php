<?php
require_once("block/header.php");
require_once("connectDB.php");


$pdo = connectDB();
$requete2 = $pdo->prepare("SELECT * FROM car WHERE id = :id;");
$requete2->execute([
    ":id" => $_GET["id"]
]);

$car = $requete2->fetch();


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