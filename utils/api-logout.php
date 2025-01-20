<?php
    require_once '../bootstrap.php';

    unset($_SESSION);
    session_destroy();

    header("Location: ../index.php");
    exit;
?>