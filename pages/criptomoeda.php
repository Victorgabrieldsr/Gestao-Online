<?php
    require "./config/session.php";
    require "../database/conexao.php";
    $_SESSION['tituloNav'] = "Painel de Criptomoeda";

    require "./config/calculoCripto.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/pages/components/nav.css">
    <link rel="stylesheet" href="../css/pages/components/PainelHistorico.css">
    <link rel="stylesheet" href="../css/pages/components/tableButton.css">
    <link rel="stylesheet" href="../css/pages/components/overlayInserir.css">
    <link rel="stylesheet" href="../css/pages/components/blocosInformativos.css">
    <link rel="stylesheet" href="../css/pages/components/exibicaoCripto.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <?php require "./components/overlayInserirCripto.php"; ?>

    <main>

        <?php 
            require "./components/nav.php"; 

            require "./components/blocosInformativosCripto.php";

            require "./components/tableButtonCripto.php";

            require "./components/historicoCripto.php";
    
            require "./components/exibicaoCripto.php";
        ?>
        
    </main>


    <script src="../js/overlay.js"></script>
    <script src="../js/nav.js"></script>
    <script src="../js/criptos.js"></script>
</body>
</html>
