<?php
    $stmt = $conn->prepare('SELECT nomeCripto FROM cotascriptos WHERE idUser = ?;');
    $stmt->bind_param('i', $_SESSION['idUser']);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $criptomoedas = [];
    while ($row = $resultado->fetch_assoc()) {
        $criptomoedas[] = $row['nomeCripto'];
    }
    
    $stmt->close();
?>

<div id="overlay-inserir" class="hidden">
    <form method="post" class="formhidden" id="form_overlay">

        <div class="form-container">
            <h2>Gerar Recebimento</h2>

            <div id="nameCriptoWrite">
                <label>Nome da Criptomoeda</label>
                <input type="text" id="nomeCripto" name="nomecripto" placeholder="Nome da Criptomoeda" required>
            </div>

            <div id="nameCriptoSelect">
                <label>Nome da Criptomoeda</label>
                <select id="SelecCripto" name="nomecripto">
                    <?php foreach ($criptomoedas as $cripto): ?>
                        <option value="<?= htmlspecialchars($cripto) ?>"><?= htmlspecialchars($cripto) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label for="datacompra">Data</label>
            <input type="date" id="datacompra" name="datacompra" required>

            <label for="descricao">Descrição</label>
            <input type="text" id="descricao" name="descricao" placeholder="Descrição">

            <label for="quantidade">Quantidade</label>
            <input type="number" id="quantidade" name="quantidade" placeholder="0" step="0.0000001" required>

            <label for="valortotal">Valor Total</label>
            <input type="number" id="valortotal" name="valortotal" placeholder="0.00" step="0.01" required>

            <input type="hidden" name="check" id="hidden_check" value="">
            <input type="hidden" name="id" value="">

            <input type="submit" value="Salvar" class="btn-form btn-submit">
            <input type="button" onclick="fecharInserir()" class="btn-form btn-cancelar" value="Cancelar">
        </div>
    </form>
</div>

