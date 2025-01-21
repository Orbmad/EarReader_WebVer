<?php
    require_once '../bootstrap.php';

    loginRedirect();

    //Insert Comment
    $db->addCommentToTopic($_SESSION["user"]["Email"], $_GET["string"], $_GET["author"], $_GET["title"]);

    //Redirect to the same topic
    $string = "Location: ../topic.php?title=" . $_GET["title"] . "&author=" . $_GET["author"];
    header($string);
    exit;
?>