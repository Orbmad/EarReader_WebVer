<?php
    function loginRedirect() {
        if (!isset($_SESSION["user"])) {
            header("Location: index.php");
            exit;
        }
    }

    function getUserCurrency() {
        if (isset($_SESSION["user"])) {
            return $_SESSION["user"]["EarCoins"];
        } else {
            return false;
        }
    }
?>