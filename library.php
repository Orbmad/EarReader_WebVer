<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader Libreria";
    $params["main"] = "library-page.php";
    $params["texts"] = $db->getUserLibrary($_SESSION["user"]["Email"]);

    require 'template/base.php';
?>