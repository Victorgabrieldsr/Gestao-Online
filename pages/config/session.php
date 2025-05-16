<?php
    if(session_start() === PHP_SESSION_NONE){
        session_start();
    }
    if(empty($_SESSION['usuario'])){
        header("Location: ./login.php");
    }
?>