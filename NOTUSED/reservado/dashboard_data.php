<?php
require "../../database/conexao.php";
if(session_start() === PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['ano'])) {
    $ano = intval($_POST['ano']);

    // ========== Fundos Imobiliários ==========
    $categoriaImobiliario = 'Fundo Imobiliario';
    $query = "WITH RECURSIVE meses AS (
        SELECT 1 AS mes
        UNION ALL
        SELECT mes + 1 FROM meses WHERE mes < 12
    )
    SELECT 
        LEFT(DATE_FORMAT(STR_TO_DATE(m.mes, '%m'), '%M'), 3) AS nomeMes,
        COALESCE(SUM(a.valorTotal), 0) AS valorTotal
    FROM meses m
    LEFT JOIN ativos a ON MONTH(a.dataCompra) = m.mes 
        AND a.categoria = ?
        AND YEAR(a.dataCompra) = ?
        AND idUser = ?
    GROUP BY m.mes
    ORDER BY m.mes;";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $categoriaImobiliario, $ano, $_SESSION['idUser']);
    $stmt->execute();
    $result = $stmt->get_result();
    $nomesAtivosImobiliarioGrafico = [];
    $valoresTotaisImobiliarioGrafico = [];
    while ($row = $result->fetch_assoc()) {
        $nomesAtivosImobiliarioGrafico[] = $row['nomeMes'];
        $valoresTotaisImobiliarioGrafico[] = floatval($row['valorTotal']);
    }

    // ========== Fundos de Investimento ==========
    $categoriaInvestimento = 'Fundo de Investimento';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $categoriaInvestimento, $ano, $_SESSION['idUser']);
    $stmt->execute();
    $result = $stmt->get_result();
    $nomesAtivosFundoInvestimentoGrafico = [];
    $valoresTotaisFundoInvestimentoGrafico = [];
    while ($row = $result->fetch_assoc()) {
        $nomesAtivosFundoInvestimentoGrafico[] = $row['nomeMes'];
        $valoresTotaisFundoInvestimentoGrafico[] = floatval($row['valorTotal']);
    }

    echo json_encode([
        'nomesAtivosImobiliarioGrafico' => $nomesAtivosImobiliarioGrafico,
        'valoresTotaisImobiliarioGrafico' => $valoresTotaisImobiliarioGrafico,
        'nomesAtivosFundoInvestimentoGrafico' => $nomesAtivosFundoInvestimentoGrafico,
        'valoresTotaisFundoInvestimentoGrafico' => $valoresTotaisFundoInvestimentoGrafico
    ]);
}
?>
