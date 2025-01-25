<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader" . $_GET["title"];
    $params["main"] = "template/read-page.php";
    $params["path"] = $_GET["text-path"] . $_GET["chapter-path"];

    require 'template/base.php';
?>