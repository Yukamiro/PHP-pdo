<?php
require_once("block/header.php");
require_once("connectDB.php");

var_dump($_SESSION["username"]);
// if (!isset($_SESSION["username"])) {
//     header("Location: index.php");
// }

?>
<a href="logout.php">Se déconnecter</a>