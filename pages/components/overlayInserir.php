<?php
    $stmt = $conn->prepare('SELECT nomeAtivo FROM cotasativos WHERE idUser = ?;');
    $stmt->bind_param('i', $_SESSION['idUser']);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $criptomoedas = [];
    while ($row = $resultado->fetch_assoc()) {
        $ativos[] = $row['nomeAtivo'];
    }
    
    $stmt->close();
?>
<div id='overlay-inserir' class='hidden'>
    <form method="post" class="formhidden" id="form_overlay_investimento">
        
        <div class='form-container'>
            <h2>Gerar Recebimento</h2>
                
            <div id="nameAtivoWrite">
                <label>Nome do Ativo</label>
                <input type='text' id='nomeativo' name='nomeativo' placeholder='Nome do Ativo'>
            </div>

            <div id="nameAtivoSelect">
                <label>Nome do Ativo</label>
                <select id="SelecAtivo" name="nomeativo">
                    <?php foreach ($ativos as $itens): ?>
                        <option value="<?= htmlspecialchars($itens) ?>"><?= htmlspecialchars($itens) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

                
            <label for='categoria'>Categoria</label>
            <select id='categoria' name='categoria' onchange='togglePorcentoAno()'>
                <option value='Ação'>Ação</option>
                <option value='Fundo Imobiliario'>Fundo Imobiliario</option>
                <option value='Fundo de Investimento'>Fundo de Investimento</option>
                <option value='Outros'>Outros</option>
            </select>
            
            <label for='datacompra'>Data</label>
            <input type='date' id='datacompra' name='datacompra' required>
            
            <label for='descricao'>Descrição</label>
            <input type='text' id='descricao' name='descricao' placeholder='Descrição'>
        
            <label for='quantidade'>Quantidade</label>
            <input type='number' id='quantidade' name='quantidade' placeholder='0' step='1' required>
            
            
            <label for='precounit'>Preço Unitario</label>
            <input type='number' id='precounit' name='precounit' placeholder='0.00' step='0.01'> 
            
            <!--                     
                <label for='valortotal'>Valor Total</label>
            <input type='number' id='valortotal' name='valortotal' placeholder='0.00' step='0.01' required> -->
            
            <div id='porcentoAno-container'>
                <label for='porcentoAno'>% por ano</label><br>
                <input type='number' id='porcentoAno' name='porcentoAno' placeholder='0%' step='0.01'>
            </div>

            <!-- <div class='checkbox-container'>
                <input type='checkbox' id='compra' name='check' value='compra' <?= $tipo === 'venda' ? '' : 'checked' ?>>
                <label for='compra'>Compra</label>
                <input type='checkbox' id='venda' name='check' value='venda' <?= $tipo === 'venda' ? 'checked' : '' ?>>
                <label for='venda'>Venda</label>
            </div> -->
            
            <input type="hidden" name="check" id="hidden_check" value="">
            <input type="hidden" name="id" value="">

            <input type="submit" value="Salvar" class="btn-form btn-submit">
            <input type="button" onclick="fecharInserir()" class="btn-form btn-cancelar" value="Cancelar">
        </div>
    </form>
</div>


