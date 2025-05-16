<?php
    require "session.php";
    require "../../database/conexao.php";

    $categoria = "Criptomoeda";  
    $datacompra = $_POST['datacompra'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $valortotal = $_POST['valortotal'];
    $tipo = $_POST['check'];
    if($tipo === 'compra'){
        $nomeCripto = $_POST['nomecripto'];
        $bola = 'bola-verde';
        $data = new DateTime($datacompra);
        $data->modify("+1 months");
        $data->setDate($data->format("Y"), $data->format("m"), 14);
        if ((int)$data->format("m") > 12) {
            $mes = (int)$data->format("m") - 12;
            $ano = (int)$data->format("Y") + 1;  
            $data->setDate($ano, $mes, 14);     
        }
        $dataComparacao = $data->format("Y-m-d");
      
    }elseif($tipo === 'venda'){
        $bola = 'bola-vermelha';
        $dataComparacao = $datacompra;
        $nomeCripto = $_POST['nomecripto'];
    
    }

    $stmt = $conn->prepare("INSERT INTO criptos(idUser, nomeCripto, categoria, dataCompra, descricao, quantidade, valorTotal, tipo, bola) 
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param('issssddss', $_SESSION['idUser'], $nomeCripto, $categoria, $datacompra, $descricao, $quantidade, $valortotal, $tipo, $bola);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT nomeCripto, quantidade, valorTotal, valorAtual FROM cotascriptos WHERE idUser = ? AND nomeCripto = ?");
    $stmt->bind_param('is', $_SESSION['idUser'], $nomeCripto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();

    if($resultado->num_rows <= 0){
        $stmt = $conn->prepare("INSERT INTO cotascriptos(idUser, nomeCripto, quantidade, valorTotal) 
        VALUES(?, ?, ?, ?);");
        $stmt->bind_param('isdd', $_SESSION['idUser'], $nomeCripto, $quantidade, $valortotal);
        $stmt->execute();
    }else if($resultado->num_rows > 0){
        if($tipo === 'compra'){ 
            if(!empty($quantidade) && !empty($valortotal)){
                $newQuantidade = $row['quantidade'] + $quantidade;
                $newValorTotal = $row['valorTotal'] + $valortotal;
            }
        }elseif($tipo === 'venda'){
            $newQuantidade = $row['quantidade'] - $quantidade;
            $newValorTotal = $row['valorTotal'] - $valortotal;
        }
        $stmt = $conn->prepare("UPDATE cotascriptos SET quantidade = ?, valorTotal = ? WHERE idUser = ? AND nomeCripto = ?");
        $stmt->bind_param('ddis', $newQuantidade, $newValorTotal, $_SESSION['idUser'], $nomeCripto);
        $stmt->execute();
    }

    $conn->close();
    header("Location: ../gestao.php?page=criptomoeda");
    exit;
?>