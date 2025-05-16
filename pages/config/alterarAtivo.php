<?php
    require "session.php";
    require "../../database/conexao.php";

    $nomeAtivo = $_POST['nomeativo'];
    $categoria = $_POST['categoria'];
    $datacompra = $_POST['datacompra'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $precounit = $_POST['precounit'];
    $porcentoAno = $_POST['porcentoAno'];
    $nomeativo_hidden = $_POST['nomeativo_hidden'];
    $categoria_hidden = $_POST['categoria_hidden'];
    $quantidade_hidden = $_POST['quantidade_hidden'];

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

 

    $stmt = $conn->prepare("UPDATE investimento.ativos SET nomeAtivo = ?, categoria = ?, dataCompra = ?, descricao = ?, quantidade = ?, precoUnitario = ?, valorTotal = ?, porcentagemAno = ?, tipo = ?, bola = ?, dataComparacao = ? WHERE id = ?;");
    $stmt->bind_param('ssssidddsssi', $nomeAtivo, $categoria, $datacompra, $descricao, $quantidade, $precounit, $valortotal, $porcentoAno, $tipo, $bola, $dataComparacao, $id);
    $stmt->execute();

    
    // ----------------------------------------------\\


    
    if($nomeativo_hidden !== $nomeAtivo || $categoria_hidden !== $categoria){
        $query = "SELECT id, nomeAtivo, categoria, quantidade FROM investimento.cotasAtivos WHERE idUser = ? AND nomeAtivo = ? AND categoria = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iss', $_SESSION['idUser'], $nomeativo_hidden, $categoria_hidden);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if(intval($quantidade_hidden) === intval($row['quantidade'])){
            //DELETE
            $sql_update = "DELETE FROM investimento.cotasAtivos WHERE idUser = ? AND nomeAtivo = ? AND categoria = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('iss', $_SESSION['idUser'], $nomeativo_hidden, $categoria_hidden);
            $stmt_update->execute();
        }
            // Verificar se o ativo já existe
        $sql_check = "SELECT quantidade FROM investimento.cotasAtivos WHERE idUser = ? AND nomeAtivo = ? AND categoria = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('iss', $_SESSION['idUser'], $nomeAtivo, $categoria);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            // Se já existir, atualiza a quantidade
            $row = $result->fetch_assoc();
            $novaQuantidade = ($row['quantidade'] + $quantidade_hidden);
            $sql_update = "UPDATE investimento.cotasAtivos SET quantidade = ?, precoUnitario = ? WHERE idUser = ? AND nomeAtivo = ? AND categoria = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('diiss', $novaQuantidade, $precounit, $_SESSION['idUser'], $nomeAtivo, $categoria);
            $stmt_update->execute();

        }else {
            // Se não existir, insere o novo ativo
            $sql_insert = "INSERT INTO investimento.cotasAtivos (idUser, nomeAtivo, categoria, quantidade, precoUnitario) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param('issid', $_SESSION['idUser'], $nomeAtivo, $categoria, $quantidade, $precounit);
            $stmt_insert->execute();

                // Verificar se o ativo já existe
            $sql_check = "SELECT quantidade FROM investimento.cotasAtivos WHERE idUser = ? AND nomeAtivo = ? AND categoria = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param('iss', $_SESSION['idUser'], $nomeativo_hidden, $categoria_hidden);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if ($result->num_rows > 0) {
                // Se já existir, atualiza a quantidade
            $row = $result->fetch_assoc();
            $novaQuantidade = ($row['quantidade'] - $quantidade);
            $sql_update = "UPDATE investimento.cotasAtivos SET quantidade = ? WHERE idUser = ? AND nomeAtivo = ? AND categoria = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('diss', $novaQuantidade, $_SESSION['idUser'], $nomeativo_hidden, $categoria_hidden);
            $stmt_update->execute();
            } 
        }
    }else{
        // Verificar se o ativo já existe
        $sql_check = "SELECT quantidade FROM investimento.cotasAtivos WHERE idUser = ? AND nomeAtivo = ? AND categoria = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('iss', $_SESSION['idUser'], $nomeAtivo, $categoria);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            // Se já existir, atualiza a quantidade
            $row = $result->fetch_assoc();
            $novaQuantidade = ($row['quantidade'] - $quantidade_hidden);
            $sql_update = "UPDATE investimento.cotasAtivos SET quantidade = ?, precoUnitario = ? WHERE idUser = ? AND nomeAtivo = ? AND categoria = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('diiss', $novaQuantidade, $precounit, $_SESSION['idUser'], $nomeAtivo, $categoria);
            $stmt_update->execute();
        } 
    }
    


    $conn->close();


    // ----------------------------------------------\\

    header("Location: ../gestao.php?page=painel_investimento");
    exit;
?>