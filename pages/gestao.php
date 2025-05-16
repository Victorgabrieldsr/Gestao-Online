<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/pages/components/lateralbar.css">
    <title>Document</title>
</head>
<body>
    <?php
        require "./components/lateralbar.php"; 
        require "./components/lateralbarInvisible.php"; 
    ?>
    <main id="main-gestao">
        <article id="article-gestao">
            <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                $file = "{$page}.php";
                if (file_exists($file)) {
                    include $file;
                } else {
                    echo "<h1>Página não encontrada</h1>";
                }
            ?>
        </article>
    </main>
</body>
</html>