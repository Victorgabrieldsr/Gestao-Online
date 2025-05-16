<?php
require "session.php";
require "../../database/conexao.php";

header('Content-Type: application/json');

$response = [
    "tipos" => [],
    "meses" => [],
];

$sqlTipos = "SELECT DISTINCT(tipo) FROM tabela_gastos WHERE idUser = ?";
$stmtTipos = $conn->prepare($sqlTipos);
$stmtTipos->bind_param('i', $_SESSION['idUser']);
$stmtTipos->execute();
$resTipos = $stmtTipos->get_result();

while ($tipo = $resTipos->fetch_assoc()) {
    $tipoAtual = [
        "nome" => $tipo['tipo'],
        "categorias" => [],
    ];

    $sqlCategorias = "SELECT DISTINCT(categoria) FROM tabela_gastos WHERE tipo = ? AND idUser = ?";
    $stmtCategorias = $conn->prepare($sqlCategorias);
    $stmtCategorias->bind_param('si', $tipo['tipo'], $_SESSION['idUser']);
    $stmtCategorias->execute();
    $resCategorias = $stmtCategorias->get_result();

    while ($categoria = $resCategorias->fetch_assoc()) {
        $categoriaAtual = [
            "nome" => $categoria['categoria'],
            "valores" => [],
        ];

        $sqlValores = "SELECT mes, valor FROM tabela_gastos WHERE tipo = ? AND categoria = ? AND idUser = ?";
        $stmtValores = $conn->prepare($sqlValores);
        $stmtValores->bind_param('ssi', $tipo['tipo'], $categoria['categoria'], $_SESSION['idUser']);
        $stmtValores->execute();
        $resValores = $stmtValores->get_result();

        while ($valor = $resValores->fetch_assoc()) {
            if (strtolower($categoria['categoria']) === 'total') {
                $sqlTotal = "SELECT SUM(valor) as total FROM tabela_gastos WHERE tipo = ? AND mes = ? AND idUser = ? AND categoria != 'total'";
                $stmtTotal = $conn->prepare($sqlTotal);
                $stmtTotal->bind_param('ssi', $tipo['tipo'], $valor['mes'], $_SESSION['idUser']);
                $stmtTotal->execute();
                $resTotal = $stmtTotal->get_result();
                $rowTotal = $resTotal->fetch_assoc();
                $valor['valor'] = $rowTotal['total'];
            }
            $categoriaAtual['valores'][] = $valor;
        }

        $tipoAtual['categorias'][] = $categoriaAtual;
    }

    $response['tipos'][] = $tipoAtual;
}

// Obter todos os meses (para o cabeçalho da tabela)
$sqlMeses = "SELECT DISTINCT(mes) FROM tabela_gastos";
$stmtMeses = $conn->prepare($sqlMeses);
$stmtMeses->execute();
$resMeses = $stmtMeses->get_result();

while ($mes = $resMeses->fetch_assoc()) {
    $response['meses'][] = $mes['mes'];
}

echo json_encode($response);
?>
