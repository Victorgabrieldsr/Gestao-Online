<?php
require "../../database/conexao.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['ano'])) {
    $ano = intval($_POST['ano']);

    // ========== Gráfico Área (Fluxo por Mês) ==========
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
        AND YEAR(a.dataCompra) = ?
        AND a.idUser = ?
    GROUP BY m.mes
    ORDER BY m.mes;";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $ano, $_SESSION['idUser']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $nomesAtivosFluxoTotalGrafico = [];
    $valoresTotaisFluxoTotalGrafico = [];
    while ($row = $result->fetch_assoc()) {
        $nomesAtivosFluxoTotalGrafico[] = $row['nomeMes'];
        $valoresTotaisFluxoTotalGrafico[] = floatval($row['valorTotal']);
    }

    // ========== Gráfico Donut (Fluxo Total por Ativo) ==========
    $query = "SELECT nomeAtivo, SUM(valorTotal) AS valorTotal 
              FROM ativos 
              WHERE YEAR(dataCompra) = ? AND idUser = ? 
              GROUP BY nomeAtivo;";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $ano, $_SESSION['idUser']);
    $stmt->execute();
    $result = $stmt->get_result();

    $nomesAtivosFluxoTotalDonut = [];
    $valoresTotaisFluxoTotalDonut = [];
    while ($row = $result->fetch_assoc()) {
        $nomesAtivosFluxoTotalDonut[] = $row['nomeAtivo'];
        $valoresTotaisFluxoTotalDonut[] = floatval($row['valorTotal']);
    }

    echo json_encode([
        'nomesAtivosFluxoTotalGrafico' => $nomesAtivosFluxoTotalGrafico,
        'valoresTotaisFluxoTotalGrafico' => $valoresTotaisFluxoTotalGrafico,
        'nomesAtivosFluxoTotalDonut' => $nomesAtivosFluxoTotalDonut,
        'valoresTotaisFluxoTotalDonut' => $valoresTotaisFluxoTotalDonut
    ]);
}
?>
