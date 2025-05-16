function AbrirInserir(){
    let overlay2 = document.querySelector('#overlay-inserir');
    overlay2.style.display = 'flex';
}

function fecharInserir() {
    let overlay2 = document.querySelector('#overlay-inserir');
    overlay2.style.display = 'none';
}

function QuantidadeEValorTotalVenda(){
    const quantidadeInput = document.getElementById('quantidade');
    const precounitInput = document.getElementById('precounit');
    
    precounitInput.addEventListener('input', function() {
        const maxValue = parseFloat(precounitInput.max);  
        let currentValue = parseFloat(precounitInput.value);
    
        let newQuantidade = (currentValue * quantidadeInput.max) / precounitInput.max;
        
        if (currentValue > maxValue) {
            precounitInput.value = maxValue;
            newQuantidade = quantidadeInput.max;
            document.getElementById('quantidade').value = newQuantidade;
        }
        
        if (currentValue < 0) {
            precounitInput.value = 0;
            newQuantidade = 0;
        }        

        document.getElementById('quantidade').value = newQuantidade.toFixed(7);
    });

    quantidadeInput.addEventListener('input', function() {
        const maxValue = parseFloat(quantidadeInput.max);  
        let currentValue = parseFloat(quantidadeInput.value);
    
        let newValorTotal = (currentValue * precounitInput.max) / quantidadeInput.max;

        if (currentValue > maxValue) {
            quantidadeInput.value = maxValue;
            newValorTotal = precounitInput.max;
        }
        
        if (currentValue < 0) {
            quantidadeInput.value = 0;
            newValorTotal = 0;
        }        
        document.getElementById('precounit').value = newValorTotal;
    });
}

function buscarDadosAtivo(ativoSelecionada) {
    if (ativoSelecionada) {
        fetch("./config/buscar_dados_investimento.php?nomeAtivo=" + encodeURIComponent(ativoSelecionada))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("precounit").value = data.precounit;
                document.getElementById("precounit").max = data.precounit;
                document.getElementById("quantidade").value = parseFloat(data.quantidade);
                document.getElementById("quantidade").max = parseFloat(data.quantidade);
            } else {
                console.warn("Nenhum dado encontrado.");
            }
        })
        .catch(error => console.error("Erro:", error));
    }
}

function openAtivoWrite(){
    AbrirInserir();
    document.getElementById('nameAtivoSelect').style.display = 'none';
    document.getElementById('nameAtivoWrite').style.display = 'flex';
    document.getElementById('SelecAtivo').disabled = true;
    document.getElementById('SelecAtivo').removeAttribute('required'); 
    document.getElementById('nomeativo').disabled = false;
    document.getElementById('nomeativo').setAttribute('required', 'true'); 
    document.getElementById("precounit").value = "";
    document.getElementById("precounit").max = "";
    document.getElementById("quantidade").value = "";
    document.getElementById("quantidade").max = "";
}

function openAtivoSelect(){
    AbrirInserir();
    document.getElementById('nameAtivoSelect').style.display = 'flex';
    document.getElementById('nameAtivoWrite').style.display = 'none';
    document.getElementById('nomeativo').disabled = true;
    document.getElementById('nomeativo').removeAttribute('required'); 
    document.getElementById('SelecAtivo').disabled = false;
    document.getElementById('SelecAtivo').setAttribute('required', 'true'); 
    document.getElementById("precounit").value = "";
    document.getElementById("precounit").max = "";
    document.getElementById("quantidade").value = "";
    document.getElementById("quantidade").max = "";
}

function handleAtivoChange(event) {
    buscarDadosAtivo(event.target.value);
}

function abrirEdicao(botao) {
    if (!botao) return; // Se o botão for nulo, sai da função

    // Pegar os dados do botão clicado (usando atributos data-*)
    const nomeAtivo = botao.getAttribute('data-nomeativo') || '';
    const dataCompra = botao.getAttribute('data-datacompra') || '';
    const descricao = botao.getAttribute('data-descricao') || '';
    const quantidade = botao.getAttribute('data-quantidade') || '0';
    const precoUnit = botao.getAttribute('data-precounit') || '';
    const tipo = botao.getAttribute('data-tipo') || '';
    const id = botao.getAttribute('data-id') || '';

    const quantidadeFormatada = parseFloat(quantidade.replace(',', '.')).toFixed(7);

    let dataFormatada = '';
    if (dataCompra.includes('/')) {
        const partes = dataCompra.split('/');
        dataFormatada = `${partes[2]}-${partes[1]}-${partes[0]}`;
    }

    // Preencher os campos do formulário da tela de edição, se existirem
    const setValue = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.value = value;
    };
    setValue('nomeativo', nomeAtivo);
    setValue('datacompra', dataFormatada);
    setValue('descricao', descricao);
    setValue('quantidade', quantidadeFormatada);
    setValue('precounit', precoUnit);
    setValue('tipo', tipo);
    setValue('id', id);
}

document.getElementById('novo_investimento').addEventListener('click', function(){
    openAtivoWrite();
    document.getElementById('form_overlay_investimento').action = "./config/inserirAtivo.php";
    document.getElementById('hidden_check').value = "compra";
});

document.getElementById('compra_investimento').addEventListener('click', function(){
    openAtivoSelect();
    document.getElementById('form_overlay_investimento').action = "./config/inserirAtivo.php";
    document.getElementById('SelecAtivo').removeEventListener('change', handleAtivoChange);
    document.getElementById('hidden_check').value = "compra";
});

document.getElementById('venda_investimento').addEventListener('click', function(){
    openAtivoSelect();
    document.getElementById('form_overlay_investimento').action = "./config/inserirAtivo.php";
    document.getElementById('SelecAtivo').addEventListener('change', handleAtivoChange);
    const primeiroValor = document.getElementById('SelecAtivo').value;
    if (primeiroValor) {
        buscarDadosAtivo(primeiroValor);
    }
    QuantidadeEValorTotalVenda();
    document.getElementById('hidden_check').value = "venda";
});

document.querySelectorAll('[id="alterar_investimento"]').forEach(botao => {
    botao.addEventListener('click', function () {
        openAtivoWrite();
        document.getElementById('form_overlay_investimento').action = "./config/alterarAtivo.php";
        abrirEdicao(this); // Passa o botão clicado como argumento
    });
});