<?php
    require "session.php";
    require "../../database/conexao.php";

    $id = $_POST['id'];
    $nomeCripto = $_POST['nomecripto'];

    $stmt = $conn->prepare("SELECT nomeCripto, quantidade, valorTotal FROM criptos WHERE nomeCripto = ? AND idUser = ?;");
    $stmt->bind_param('si', $nomeCripto, $_SESSION['idUser']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $numRows = $resultado->num_rows;

    $stmt = $conn->prepare("SELECT nomeCripto, quantidade, valorTotal, tipo FROM criptos WHERE id = ? AND idUser = ?;");
    $stmt->bind_param('ii', $id, $_SESSION['idUser']);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if($resultado->num_rows > 0){
        $row = $resultado->fetch_assoc();
        $deleteQuantidade = $row['quantidade'];
        $deleteValorTotal = $row['valorTotal'];
        $deleteNomeCripto = $row['nomeCripto'];
        $deleteTipo = $row['tipo'];
    }

    if($numRows === 1){
        $stmt = $conn->prepare("DELETE FROM cotascriptos WHERE idUser = ? AND nomeCripto = ?");   
        $stmt->bind_param('is', $_SESSION['idUser'], $deleteNomeCripto);
        $stmt->execute();
    }else if($numRows !== 1){
        $stmt = $conn->prepare("SELECT nomeCripto, quantidade, valorTotal, valorAtual FROM cotascriptos WHERE idUser = ? AND nomeCripto = ?;");
        $stmt->bind_param('is', $_SESSION['idUser'], $nomeCripto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        if($deleteTipo === 'compra'){
            $newQuantidade = $row['quantidade'] - $deleteQuantidade;
            $newValorTotal = $row['valorTotal'] - $deleteValorTotal;
        }elseif($deleteTipo === 'venda'){
            $newQuantidade = $row['quantidade'] + $deleteQuantidade;
            $newValorTotal = $row['valorTotal'] + $deleteValorTotal;
        }

        $stmt = $conn->prepare("UPDATE cotascriptos SET quantidade = ?, valorTotal = ? WHERE idUser = ? AND nomeCripto = ?");
        $stmt->bind_param('ddis', $newQuantidade, $newValorTotal, $_SESSION['idUser'], $deleteNomeCripto);
        $stmt->execute();
    }

    $stmt = $conn->prepare("DELETE FROM criptos WHERE id = ? AND idUser = ?;");
    $stmt->bind_param('ii', $id, $_SESSION['idUser']);
    $stmt->execute();
    
    require "calculoInvestimento.php"; 

    header("Location: ../gestao.php?page=criptomoeda");
    exit;
?>