<?php

$_SESSION['totalRendimento'] = number_format(0, 2, ',', '.');
$_SESSION['totalProventoMes'] = number_format(0, 2, ',', '.');
$_SESSION['totalInvestido'] = number_format(0, 2, ',', '.');
$_SESSION['totalRetirado'] = number_format(0, 2, ',', '.');
$_SESSION['porcentagemTotal'] = number_format(0, 2, ',', '.');

$dataAtual = date("Y/m/d");

// Calculo Fundo Imobiliario

$stmt = $conn->prepare("SELECT nomeAtivo, valorTotal, dataCompra, tipo, quantidade, precoUnitario, dataComparacao 
                        FROM investimento.ativos 
                        WHERE idUser = ? AND categoria = 'Fundo Imobiliario'
                        ORDER BY dataCompra ASC;"); 
$stmt->bind_param('s', $_SESSION['idUser']);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows > 0){
    $totalInvestido = 0;
    $totalRetirado = 0;
    $totalProventoMes = 0;
    $totalRendimento = 0;
    $porcento = 1;
    $total_porcentagem = $porcento / 100;
    while($row = $resultado->fetch_assoc()){
        $ativo = $row['nomeAtivo'];

        if($dataAtual >= $row['dataComparacao']) {
            $data1 = new DateTime($dataAtual);
            $data2 = new DateTime($row['dataComparacao']);
            $anos = $data1->format('Y') - $data2->format('Y');
            $meses = $data1->format('m') - $data2->format('m');
            $totalMeses = ($anos * 12) + $meses;
        }
        
        if($row['tipo'] === 'compra') {
            $totalInvestido += $row['valorTotal'];
            $proventoMensal = (($row['precoUnitario'] * $total_porcentagem) *  $row['quantidade']);
            $totalRendimento += ($proventoMensal * $totalMeses);
            $totalProventoMes += $proventoMensal;
        } elseif($row['tipo'] === 'venda') {
            $proventoMensal = (($row['precoUnitario'] * $total_porcentagem) * $row['quantidade']);
            $totalRendimento -= ($proventoMensal * $totalMeses);
            $totalProventoMes -= $proventoMensal;
            $totalRetirado += $row['valorTotal'];
        }
    }

    $_SESSION['totalRendimento'] = number_format($totalRendimento, 2, ',', '.');
    $_SESSION['totalProventoMes'] = number_format($totalProventoMes, 2, ',', '.');
    $totalInvestido = ($totalInvestido - $totalRetirado) + $totalRendimento;
    $_SESSION['totalInvestido'] = number_format($totalInvestido, 2, ',', '.');
    $_SESSION['totalRetirado'] = number_format($totalRetirado, 2, ',', '.');
    $porcentagemTotal = ($totalRendimento * 100) / $totalInvestido;
    $_SESSION['porcentagemTotal'] = number_format($porcentagemTotal, 2, ',', '.');
}

//Calculo Ação




// Calculo Fundo de Investimento






?>
