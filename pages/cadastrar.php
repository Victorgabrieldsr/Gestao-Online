<?php
    if(session_start() === PHP_SESSION_NONE){
        session_start();
    }
    unset($_SESSION['usuario']);
?>   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/pages/login.css">
</head>
<body>
    <div class='page'>
        <form action='./config/cadastrar.php' method='POST' class='formLogin'>
            <h1>Registrar</h1>
            <label>Usuario</label>
            <input type='text' name='usuario' placeholder='Digite seu usuario' autofocus='true' />
            <label for='password'>Senha</label>
            <input type='password' name='senha1' placeholder='Digite sua senha' />
            <input type='password' name='senha2' placeholder='Confirme sua senha' />
            <input type='submit' value='Acessar' class='btn' />
            <a href="login.php">Já tenho cadastro!</a>
        </form>
    </div>
</body>
</html>