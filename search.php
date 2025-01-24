<?php
    require_once 'bootstrap.php';

    loginRedirect();

    //Params
    $params["title"] = "Ear-Reader Ricerca";
    $params["main"] = "template/search-page.php";

    //Search Params
    if (isset($_GET["info"]) && $_GET["info"] == "search-bar" && isset($_GET["type"])) {
        //Show texts
        if ($_GET["type"] == "title") {
            $params["texts"] = $db->searchTextsByTitleLike($_GET["search"]);
        } else if ($_GET["type"] == "author") {
            $params["texts"] = $db->searchTextsByAuthorLike($_GET["search"]);
        } else if ($_GET["type"] == "genre") {
            $params["texts"] = $db->searchTextsByGenreLike($_GET["search"]);
        } else if ($_GET["type"] == "group") {
            $params["texts"] = $db->searchTextByGroupLike($_GET["search"]);
        }
        
    } else if (isset($_GET["info"]) && $_GET["type"] == "title") {
        //Show texts from title
        $params["texts"] = $db->searchTextsByTitleLike($_GET["search"]);
    } else if (isset($_GET["info"]) && $_GET["type"] == "genres") {
        //Show texts from genres
        $params["texts"] = $db->searchTextsByGenreLike($_GET["search"]);
    } else if (isset($_GET["info"]) && $_GET["type"] == "authors") { 
        //Show authors
        $params["authors"] = $db->searchAuthorLike($_GET["search"]);

    } else if (isset($_GET["info"]) && $_GET["type"] == "topics") {
        //Show topics
        $params["topics"] = $db->searchTopicLike($_GET["search"]);

    } else if (isset($_GET["info"]) && $_GET["type"] == "groups") {
        //Show groups
        $params["groups"] = $db->searchGroupsLike($_GET["search"]);

    } else {
        $params["texts"] = $db->getAllTexts();
    }

    require 'template/base.php';
?>