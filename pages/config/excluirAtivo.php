<?php
    require "session.php";
    require "../../database/conexao.php";

    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM ativos WHERE id = ? AND idUser = ?;");
    $stmt->bind_param('ii', $id, $_SESSION['idUser']);
    $stmt->execute();
    
    require "calculoInvestimento.php";

    header("Location: ../gestao.php?page=painel_investimento");
    exit;
?>