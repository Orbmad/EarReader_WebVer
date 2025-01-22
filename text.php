<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader " . $_GET["title"];
    $params["main"] = "text-page.php";
    $params["text"] = $db->getText($_GET["code"]);
    $params["chapters"] = $db->getChaptersOfText($_GET["code"]);
    $params["reviews"] = $db->getReviewsOfText($_GET["code"]);
    $params["tags"] = $db->getTagsOfText($_GET["code"]);
    $params["authors"] = $db->getAuthorsOfText($_GET["code"]);

    require 'template/base.php';
?>