<?php
    require "./config/session.php";
    require "../database/conexao.php";
    $arr_session_painel = ['totalInvestido', 'totalRendimento', 'totalProventoMes', 'totalRetirado', 'porcentagemTotal'];
    foreach($arr_session_painel as $item){
        if(!isset($_SESSION[$item])){
            $_SESSION[$item] = 0;
        }
    }
    $_SESSION['tituloNav'] = "Painel de Investimento";
    
    require "./config/calculoInvestimento.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/pages/components/PainelHistorico.css">
    <link rel="stylesheet" href="../css/pages/components/lateralbar.css">
    <link rel="stylesheet" href="../css/pages/components/nav.css">
    <link rel="stylesheet" href="../css/pages/components/overlayInserir.css">
    <link rel="stylesheet" href="../css/pages/components/blocosInformativos.css">
    <link rel="stylesheet" href="../css/pages/components/tableButton.css">
<body>

    <?php require "./components/overlayInserir.php"; ?>

    <main>
               
        <?php 
            require "./components/nav.php"; 
            
            require "./components/blocosInformativos.php"; 

            require "./components/tableButton.php";

            require "./components/historicoInvestimento.php";
        ?>
    
    </main>
    <script src="../js/overlay.js"></script>
    <script src="../js/nav.js"></script>
    <script src="../js/painel_investimento.js"></script>
</body>
</html>