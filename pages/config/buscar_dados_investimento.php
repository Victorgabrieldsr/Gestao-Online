<?php
    require "session.php";
    require "../../database/conexao.php";

    if (isset($_GET['nomeAtivo'])) {
        $nomeAtivo = $_GET['nomeAtivo'];
        $idUser = $_SESSION['idUser']; // Pega o ID do usuário logado

        $stmt = $conn->prepare("SELECT precoUnitario, quantidade FROM cotasativos WHERE nomeAtivo = ? AND idUser = ?;");
        $stmt->bind_param('si', $nomeAtivo, $idUser);
        $stmt->execute();
        $resultado = $stmt->get_result();   
        if ($resultado->num_rows > 0) {
            $dados = $resultado->fetch_assoc();
            echo json_encode(["success" => true, "precounit" => $dados['precoUnitario'], "quantidade" => $dados['quantidade']]);
        } else {
            echo json_encode(["success" => false]);
        }
    } else {
        echo json_encode(["success" => false]);
    }
?>
