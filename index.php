<?php
    if(session_start() === PHP_SESSION_NONE){
        session_start();
    }
    header("Location: ./pages/login.php");
    exit;
?>