<?php
    if(session_start() === PHP_SESSION_NONE){
        session_start();
    }
    require "../../database/conexao.php";
    $token = $_COOKIE['remember_me'];
    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ? ");
    $stmt->bind_param("i", $_SESSION['idUser']);
    $stmt->execute();
    
    setcookie("remember_me", '', time() - 3600, '/');
    session_destroy();
    session_unset();
    header("Location: ../login.php");
?>