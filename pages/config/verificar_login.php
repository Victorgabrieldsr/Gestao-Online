<?php   
    require "../../database/conexao.php";
    if(session_start() === PHP_SESSION_NONE){
        session_start();
    }
    
    if(isset($_COOKIE['remember_me'])){
        header("Location: ../gestao.php?page=painel_investimento");
        exit;
    }

    $usuario = strtolower($_POST['usuario']);
    $senha = strtolower($_POST['senha']);

    if ($conn->connect_error) {
        die("Sem conexão com o servidor: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("SELECT id, usuario, senha FROM users WHERE usuario = ?;");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();

        if(password_verify($senha, $row['senha'])){
            if(isset($_POST['lembrar'])){
                $token = bin2hex(random_bytes(32));
                setcookie('remember_me', $token, [
                    'expires' => time() + (30 * 24 * 60 * 60),  // 30 dias
                    'path' => '/',
                    'secure' => true,                           // Somente HTTPS
                    'httponly' => true,                         // Proíbe acesso via JavaScript
                    'samesite' => 'Lax'                         // Protege contra CSRF
                ]);
        
                $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                $stmt->bind_param("si", $token, $row['id']);
                $stmt->execute();
            }
            $_SESSION['idUser'] = $row['id'];
            $_SESSION['usuario'] = $usuario;
            header("Location: ../gestao.php?page=painel_investimento");
            exit;
        }
    }

    $stmt->close();
    $conn->close();
    header("Location: ../login.php");
    exit;


   
?>
