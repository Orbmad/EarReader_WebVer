<?php
require_once '../bootstrap.php';

if (isset($_POST["back"])) {
    header("Location: ../index.php");
    exit;
} else {
    if (isset($_POST["nickname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["checkpassword"])) {
        if ($_POST["password"] == $_POST["checkpassword"]) {
            $db->newUser($_POST["nickname"], $_POST["email"], $_POST["password"]);
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION["signupMsg"] = "ERRORE: Le password inserite sono diverse!";
            header("Location: ../signup.php");
            exit; 
        }
    } else {
        $_SESSION["signupMsg"] = "ERRORE: Impossibile effettuare la registrazione!";
        header("Location: ../signup.php");
        exit;
    }
}
