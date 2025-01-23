<?php
    require_once '../bootstrap.php';

    $string = "Location: ../search.php";

    if (isset($_GET["info"]) && $_GET["info"] == "search-bar" && isset($_GET["type"])) {
        $string = $string . "?type=" . $_GET["type"] . "&info=search-bar" . "&search=" . $_GET["search"];
    }

    header($string);
    exit;
?>