<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once("utils/functions.php");
    require_once("database/database.php");
    $db = new Database("localhost", "root", "", "plantatio", 3306);


?> 