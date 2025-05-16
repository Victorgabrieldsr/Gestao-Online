<?php   
    require "../../database/conexao.php";
    if(session_start() === PHP_SESSION_NONE){
        session_start();
    }

    $usuario =strtolower($_POST['usuario']);
    $senha1 = strtolower($_POST['senha1']);
    $senha2 = strtolower($_POST['senha2']);

    if ($conn->connect_error) {
        die("Sem conexão com o servidor: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE usuario = ?;");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows <= 0) {
        if($senha1 === $senha2){
            $senha = password_hash($senha1, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users(usuario, senha) VALUES (?, ?);");
            $stmt->bind_param("ss", $usuario, $senha);
            $stmt->execute();

            $stmt = $conn->prepare("SELECT id FROM users WHERE usuario = ?;");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                $idUser = $row['id'];
            }

            $meses = ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'];
            $dados = [
                ['tipo' => 'caixa', 'categoria' => 'salario'],
                ['tipo' => 'caixa', 'categoria' => 'investimentos'],
                ['tipo' => 'caixa', 'categoria' => 'renda extra'],
                ['tipo' => 'caixa', 'categoria' => 'outros'],
                ['tipo' => 'caixa', 'categoria' => 'total'],
                ['tipo' => 'despesas', 'categoria' => 'agua'],
                ['tipo' => 'despesas', 'categoria' => 'luz'],
                ['tipo' => 'despesas', 'categoria' => 'telefone'],
                ['tipo' => 'despesas', 'categoria' => 'cartao de credito'],
                ['tipo' => 'despesas', 'categoria' => 'lazer'],
                ['tipo' => 'despesas', 'categoria' => 'investido'],
                ['tipo' => 'despesas', 'categoria' => 'total'],
                ['tipo' => 'investimentos', 'categoria' => 'rendimento'],
                ['tipo' => 'investimentos', 'categoria' => 'saques'],
                ['tipo' => 'investimentos', 'categoria' => 'total'],
                ['tipo' => 'investimentos', 'categoria' => 'total investido'],
            ];

            $ano = 2025;

            $sql = "INSERT INTO tabela_gastos (idUser, tipo, categoria, mes, ano) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Erro na preparação: " . $conn->error);
            }

            foreach ($meses as $mes) {
                foreach ($dados as $dado) {
                    $stmt->bind_param('isssi', $idUser, $dado['tipo'], $dado['categoria'], $mes, $ano);
                    if (!$stmt->execute()) {
                        echo "Erro ao inserir: " . $stmt->error . "<br>";
                    }
                }
            }


            header("location: ../login.php");
            exit;
        }
    }
    $conn->close();
    header("location: ../cadastrar.php");
    exit;
?>
