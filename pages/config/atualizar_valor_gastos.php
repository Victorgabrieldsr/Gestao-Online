<?php
require "session.php";
require "../../database/conexao.php";

$data = json_decode(file_get_contents('php://input'), true);

$tipo = $data['tipo'];
$categoria = $data['categoria'];
$mes = $data['mes'];
$valor = $data['valor'];
$idUser = $_SESSION['idUser']; 

$valor = str_replace('R$', '', $valor);

// Corrigir formato brasileiro (ex: 1.500,50 -> 1500.50)
$valor = str_replace('.', '', $valor); 
$valor = str_replace(',', '.', $valor); 
$valor = floatval($valor);

// Atualiza o valor específico
$sql = "UPDATE tabela_gastos SET valor = ? WHERE tipo = ? AND categoria = ? AND mes = ? AND idUser = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('dsssi', $valor, $tipo, $categoria, $mes, $idUser);
$stmt->execute();
$stmt->close(); // <- FECHA aqui o primeiro statement
?>
