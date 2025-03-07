<?php
if (isset($_SESSION["username"])) {
    unset($_SESSION["username"]);
}

if (session_reset()) {
    session_destroy();
}

header("Location: index.php");
