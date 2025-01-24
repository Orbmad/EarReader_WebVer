<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader Shop";
    $params["main"] = "shop-page.php";
    $params["js"] = array("js/shop.js");
    $params["table"] = $db->getDiscountTable();
    $params["payments"] = $db->getPaymentMethods();

    require 'template/base.php';
?>