<?php
require "../../database/conexao.php";
session_start();

$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$registrosPorPagina = 5;
$offset = ($pagina - 1) * $registrosPorPagina;

// Conta o total de registros para calcular o número de páginas
$sqlTotal = "SELECT COUNT(*) as total FROM investimento.criptos WHERE idUser = ?";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bind_param("i", $_SESSION['idUser']);
$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();
$totalRegistros = $resultTotal->fetch_assoc()['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Busca os registros da página atual
$sql = "SELECT id, nomeCripto, DATE_FORMAT(dataCompra, '%d/%m/%Y') as dataCompra, descricao, quantidade, valorTotal, quantidadeAtual, valorAtual, tipo, bola 
        FROM investimento.criptos 
        WHERE idUser = ? 
        ORDER BY dataCompra DESC, id DESC 
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $_SESSION['idUser'], $registrosPorPagina, $offset);
$stmt->execute();
$result = $stmt->get_result();

$dadosCriptos = [];
while ($row = $result->fetch_assoc()) {
    $dadosCriptos[] = $row;
}

$response = [
    "criptos" => $dadosCriptos,
    "totalPaginas" => $totalPaginas
];

echo json_encode($response);
?>
