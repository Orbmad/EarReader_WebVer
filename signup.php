<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader SignUp";
    $params["main"] = "signup-form.php";
    $params["js"] = array("js/login.js");
    
    require 'template/base.php';
?>