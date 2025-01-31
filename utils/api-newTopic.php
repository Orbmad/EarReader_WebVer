<?php
    require_once '../bootstrap.php';

    $db->newTopic($_SESSION["user"]["Email"], $_GET["title"], $_GET["text"], $_GET["arg"]);

    header("Location: ../home.php");
    exit;
?>