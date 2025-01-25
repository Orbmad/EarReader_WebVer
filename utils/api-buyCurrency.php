<?php
    require_once '../bootstrap.php';

    var_dump(strval($_SESSION["user"]["Email"]));

    $db->buyNewCurrency($_SESSION["user"]["Email"], $_POST["qt"], $db->getMethodCodeFromMethodName($_POST["method"]), $db->getDiscountCodeFromQuantity($_POST["qt"]));
    $db->addCurrency($_SESSION["user"]["Email"], $_POST["qt"]);
    $_SESSION["user"]["EarCoins"] = $db->getUserCurrency($_SESSION["user"]["Email"]);

    header("Location: ../home.php");
    exit;
?>