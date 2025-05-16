<?php
    require "../database/conexao.php";

    if(session_start() === PHP_SESSION_NONE){
        session_start();
    }


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
        <?php
        if(isset($_COOKIE['remember_me'])){
            $token = $_COOKIE['remember_me'];
            $stmt = $conn->prepare("SELECT id, usuario FROM users WHERE remember_token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if($resultado->num_rows > 0){
                $row = $resultado->fetch_assoc();
                $_SESSION['idUser'] = $row['id'];
                $_SESSION['usuario'] = $row['usuario'];
            }
            echo"
            <form action='./config/verificar_login.php' method='POST' class='formLogin'>
                <h1>Login</h1>
                <input type='submit' value='Entrar com ". $_SESSION['usuario'] ." ' class='btn' />
                <a href='./config/deslogar.php'>Deslogar!</a>
            </form>
            ";
        }else{
            echo"
            <form action='./config/verificar_login.php' method='POST' class='formLogin'>
                <h1>Login</h1>
                <label>Usuario</label>
                <input type='text' name='usuario' placeholder='Digite seu usuario' autofocus='true' />
                <label for='password'>Senha</label>
                <input type='password' name='senha' placeholder='Digite sua senha' />
                <input type='submit' value='Acessar' class='btn' />
                <label>Lembre-se de mim: <input type='checkbox' name='lembrar'></label><br>
                <a href='cadastrar.php'>Não tenho cadastro!</a>
            </form>
            ";
        }
        ?>
       
    </div>
</body>
</html>