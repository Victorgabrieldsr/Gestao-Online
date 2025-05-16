<?php
    require "session.php";
    require "../../database/conexao.php";

    $nomeCripto = $_POST['nomeCripto'];
    $categoria = $_POST['categoria'];
    $datacompra = $_POST['datacompra'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    

    $id = $_POST['id'];
    $tipo = $_POST['check'];
    if($tipo === 'compra'){
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
    }

    $valortotal = $precounit * $quantidade;

    $stmt = $conn->prepare("UPDATE investimento.criptos SET nomecripto = ?, dataCompra = ?, descricao = ?, quantidade = ?, valorTotal = ?, tipo = ?, bola = ? WHERE id = ?;");
    $stmt->bind_param('sssddssi', $nomeCripto, $datacompra, $descricao, $quantidade, $valortotal, $tipo, $bola, $id);
    $stmt->execute();
    $conn->close();


    // ----------------------------------------------\\

    header("Location: ../gestao.php?page=criptomoeda");
    exit;
?>