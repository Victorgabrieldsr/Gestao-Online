<?php
    require "./config/session.php";
    require "../database/conexao.php";
    $_SESSION['tituloNav'] = "Gastos";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/pages/components/nav.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/pages/gastos.css">
    <title>Document</title>
</head>
<body>
    
    <main>
        <?php require "./components/nav.php"; ?>
        <center>
            <article class="divisor">
              <table id="tabela_gastos"></table>
             
            </center>
          </article>
        </main>

<script src="../js/nav.js"></script>
<script src="../js/gastos.js"></script>
</body>
</html>