<?php
    require "session.php";
    require "../../database/conexao.php";

    if (isset($_GET['nomecripto'])) {
        $nomecripto = $_GET['nomecripto'];
        $idUser = $_SESSION['idUser']; // Pega o ID do usuário logado

        $stmt = $conn->prepare("SELECT valortotal, quantidade FROM cotascriptos WHERE nomeCripto = ? AND idUser = ?");
        $stmt->bind_param('si', $nomecripto, $idUser);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $dados = $resultado->fetch_assoc();
            echo json_encode(["success" => true, "valortotal" => $dados['valortotal'], "quantidade" => $dados['quantidade']]);
        } else {
            echo json_encode(["success" => false]);
        }
    } else {
        echo json_encode(["success" => false]);
    }
?>
