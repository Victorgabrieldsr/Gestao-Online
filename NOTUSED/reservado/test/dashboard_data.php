<?php
require "../../database/conexao.php";
session_start();

if (isset($_POST['ano'])) {
    $ano = intval($_POST['ano']);
    $categoria = 'Fundo Imobiliario';

    // Consulta para o gráfico de área
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
    $stmt->bind_param('sii', $categoria, $ano, $_SESSION['idUser']);
    $stmt->execute();
    $result = $stmt->get_result();

    $nomesAtivosImobiliarioGrafico = [];
    $valoresTotaisImobiliarioGrafico = [];
    while ($row = $result->fetch_assoc()) {
        $nomesAtivosImobiliarioGrafico[] = $row['nomeMes'];
        $valoresTotaisImobiliarioGrafico[] = floatval($row['valorTotal']);
    }

    // Consulta para o gráfico de donut
    $query = "SELECT nomeAtivo, SUM(valorTotal) AS valorTotal 
              FROM ativos 
              WHERE categoria = ? AND YEAR(dataCompra) = ? AND idUser = ? 
              GROUP BY nomeAtivo;";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $categoria, $ano, $_SESSION['idUser']);
    $stmt->execute();
    $result = $stmt->get_result();

    $nomesAtivosImobiliario = [];
    $valoresTotaisImobiliario = [];
    while ($row = $result->fetch_assoc()) {
        $nomesAtivosImobiliario[] = $row['nomeAtivo'];
        $valoresTotaisImobiliario[] = floatval($row['valorTotal']);
    }

    echo json_encode([
        'nomesAtivosImobiliarioGrafico' => $nomesAtivosImobiliarioGrafico,
        'valoresTotaisImobiliarioGrafico' => $valoresTotaisImobiliarioGrafico,
        'nomesAtivosImobiliario' => $nomesAtivosImobiliario,
        'valoresTotaisImobiliario' => $valoresTotaisImobiliario
    ]);
}
?>
