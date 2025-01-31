<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader Nuova discussione";
    $params["main"] = "template/newTopic.php";


    require 'template/base.php';
?>