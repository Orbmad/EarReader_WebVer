<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader Home";
    $params["main"] = "home-content.php";
    
    require 'template/base.php';
?>