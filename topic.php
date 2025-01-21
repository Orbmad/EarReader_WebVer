<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader" . $_GET["title"];
    $params["main"] = "topic-page.php";
    $params["topic"] = $db->getTopic($_GET["author"], $_GET["title"])[0];
    $params["comments"] = $db->getCommentsOfTopic($_GET["author"], $_GET["title"]);

    require 'template/base.php';
?>