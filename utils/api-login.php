<?php
    require_once '../bootstrap.php';

    if (isset($_POST["signup"])) {
        header("Location: ../signup.php");
        exit;
    } else {
        $_SESSION["user"] = $db->checkLogin($_POST["email"], $_POST["password"]);
        if (isset($_SESSION["user"])) {
            header("Location: ../home.php");
            exit;
        } else {
            $_SESSION["loginMsg"] = "ERRORE: Email o password errate!";
            header("Location: ../index.php");
            exit;
        }
    }
?>