<?php
    require_once '../bootstrap.php';

    if(isset($_GET["code"]) && isset($_GET["cost"])) {
        if ($_GET["cost"] > $_SESSION["user"]["EarCoins"]) {
            $buyNewCurrency = "Location: ../shop.php";
            header($buyNewCurrency);
            exit;
        }
        $db->buyChapter($_SESSION["user"]["Email"], $_GET["code"], $_GET["number"], $_GET["cost"]);
        $_SESSION["user"]["EarCoins"] = $db->getUserCurrency($_SESSION["user"]["Email"]);
    }

    $string = "Location: ../text.php?code=" . $_GET["code"] . "&title=" . $_GET["title"];
    header($string);
    exit;
?>