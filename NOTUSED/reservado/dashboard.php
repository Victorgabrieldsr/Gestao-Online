<?php
require "./config/session.php";
require "../database/conexao.php";

// Carrega os anos disponíveis
$categoria = 'Fundo Imobiliario';
$query = "SELECT DISTINCT YEAR(dataCompra) AS ano FROM ativos WHERE  idUser = ? ORDER BY ano ASC;";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $_SESSION['idUser']);
$stmt->execute();
$result = $stmt->get_result();
$anos = [];
while ($row = $result->fetch_assoc()) {
    $anos[] = $row['ano'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/pages/painel.css">
    <link rel="stylesheet" href="../css/pages/dashboard.css">
    <link rel="stylesheet" href="../css/pages/components/nav.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <main>
        <?php require "./components/nav.php"; ?>

        <!-- Dropdown de seleção de ano -->
        <article class="divisor">
            <select id="anoSelect" onchange="carregarGraficos()">
                <?php foreach ($anos as $ano): ?>
                    <option value="<?php echo $ano; ?>"><?php echo $ano; ?></option>
                <?php endforeach; ?>
            </select>
        </article>

        <!-- Gráficos -->
        <article class="divisor">
            <div id="chart1" class="dash-circle"></div>
            <div id="chart2" class="dash-grafic"></div>
        </article>
        <article class="divisor">
            <div id="chart3" class="dash-circle"></div>
            <div id="chart4" class="dash-grafic"></div>
        </article>
    </main>

    <!-- Scripts -->
    <script>
        let chart1, chart2, chart3, chart4;

        function carregarGraficos() {
            const ano = document.getElementById('anoSelect').value;

            fetch('./config/dashboard_data.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `ano=${ano}`
            })
            .then(response => response.json())
            .then(data => {
                // Remove os gráficos antigos se existirem
                if (chart1) chart1.destroy();
                if (chart2) chart2.destroy();
                if (chart3) chart3.destroy();
                if (chart4) chart4.destroy();

                // Renderiza os novos gráficos
                chart1 = gerarGraficoDonut(data.valoresTotaisImobiliarioGrafico, data.nomesAtivosImobiliarioGrafico, 'Fundos Imobiliários', 'chart1');
                chart2 = gerarGraficoArea(data.valoresTotaisImobiliarioGrafico, data.nomesAtivosImobiliarioGrafico, 'Fundos Imobiliários', 'chart2');
                chart3 = gerarGraficoDonut(data.valoresTotaisFundoInvestimentoGrafico, data.nomesAtivosFundoInvestimentoGrafico, 'Fundos de Investimento', 'chart3');
                chart4 = gerarGraficoArea(data.valoresTotaisFundoInvestimentoGrafico, data.nomesAtivosFundoInvestimentoGrafico, 'Fundos de Investimento', 'chart4');
            })
            .catch(error => console.error('Erro:', error));
        }


        function gerarGraficoDonut(valores, labels, titulo, elementoId) {
            let options = {
                series: valores,
                chart: { type: 'donut' },
                title: { text: titulo, align: 'center' },
                labels: labels,
                tooltip: {
                    y: {
                        formatter: value => 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    }
                },
                responsive: [{ breakpoint: 480, options: { chart: { width: 100 }, legend: { position: 'bottom' } } }]
            };
            let chart = new ApexCharts(document.querySelector("#" + elementoId), options);
            chart.render();
            return chart;
        }

        function gerarGraficoArea(dados, categorias, titulo, elementoId) {
            let options = {
                series: [{ name: "", data: dados }],
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    }
                },
                chart: { type: 'area', height: 350, zoom: { enabled: false } },
                title: { text: titulo, align: 'left' },
                xaxis: { categories: categorias },
                yaxis: { opposite: true },
                dataLabels: {
                    enabled: false
                },
                stroke: { curve: 'smooth' }
            };
            let chart = new ApexCharts(document.querySelector("#" + elementoId), options);
            chart.render();
            return chart;
        }

        // Carrega os gráficos com o primeiro ano disponível
        carregarGraficos();
    </script>

    <script src="../js/nav.js"></script>
</body>
</html>
