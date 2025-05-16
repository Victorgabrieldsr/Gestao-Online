<?php
$totalCripto = 0;
$totalRetirado = 0;

$_SESSION['totalInvestidoCripto'] = number_format(0, 2, ',', '.');
$_SESSION['totalCripto'] = number_format(0, 2, ',', '.');
$_SESSION['totalLucroEPerda'] = number_format(0, 2, ',', '.');
$_SESSION['totalRetiradoCripto'] = number_format(0, 2, ',', '.');

$dataAtual = date("Y/m/d");

// Calculo Fundo Imobiliario

$stmt = $conn->prepare("SELECT nomeCripto, valorTotal, dataCompra, tipo, quantidade FROM investimento.criptos WHERE idUser = ? AND categoria = 'Criptomoeda' ORDER BY dataCompra ASC;"); 
$stmt->bind_param('s', $_SESSION['idUser']);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows > 0){
    while($row = $resultado->fetch_assoc()){
       if($row['tipo'] === 'venda') {
            $totalRetirado += $row['valorTotal'];
        }
    }
    $_SESSION['totalRetiradoCripto'] = number_format($totalRetirado, 2, ',', '.');
}


$resultado = $conn->query("SELECT SUM(valorTotal) as somaTotal FROM cotascriptos;"); 
if($resultado->num_rows > 0){
    $row = $resultado->fetch_assoc();
    if($row['somaTotal'] !== null){
        $_SESSION['totalCripto'] = number_format($row['somaTotal'], 2, ',', '.');
    }
}

$resultado = $conn->query("SELECT SUM(valorTotal) AS somaTotal FROM criptos WHERE tipo = 'compra';"); 
if($resultado->num_rows > 0){
    $row = $resultado->fetch_assoc();
     if($row['somaTotal'] !== null){
        $_SESSION['totalInvestidoCripto'] = number_format($row['somaTotal'], 2, ',', '.');
     }
}

//Calculo Ação

// Calculo Fundo de Investimento

?>