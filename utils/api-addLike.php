<?php
    require_once '../bootstrap.php';

    $like = $_GET["like"] == "up" ? 1 : 0;
    $db->addLike($_SESSION["user"]["Email"], $_GET["author"], $_GET["title"], $_GET["code"], $like);

    $string = "Location: ../topic.php?author=" . $_GET["author"] . "&title=" . $_GET["title"];
    header($string);
    exit;
?>