<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader Home";
    $params["main"] = "home-content.php";
    $params["suggested"] = $db->suggestedTexts($_SESSION["user"]["Email"]);
    $params["bests"] = $db->getTextRanking();
    $params["authors"] = $db->getAuthorRanking();
    $params["topics"] = $db->getTopicRanking();
    $params["groups"] = $db->getGroups();
    

    require 'template/base.php';
?>