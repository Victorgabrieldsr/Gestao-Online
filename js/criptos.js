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
    const valortotalInput = document.getElementById('valortotal');
    
    valortotalInput.addEventListener('input', function() {
        const maxValue = parseFloat(valortotalInput.max);  
        let currentValue = parseFloat(valortotalInput.value);
    
        let newQuantidade = (currentValue * quantidadeInput.max) / valortotalInput.max;
        
        
        if (currentValue > maxValue) {
            valortotalInput.value = maxValue;
            newQuantidade = quantidadeInput.max;
        }
        
        if (currentValue < 0) {
            valortotalInput.value = 0;
            newQuantidade = 0;
        }        

        document.getElementById('quantidade').value = newQuantidade.toFixed(7);
    });

    quantidadeInput.addEventListener('input', function() {
        const maxValue = parseFloat(quantidadeInput.max);  
        let currentValue = parseFloat(quantidadeInput.value);
    
        let newValorTotal = (currentValue * valortotalInput.max) / quantidadeInput.max;

        if (currentValue > maxValue) {
            quantidadeInput.value = maxValue;
            newValorTotal = valortotalInput.max;
        }
        
        if (currentValue < 0) {
            quantidadeInput.value = 0;
            newValorTotal = 0;
        }        
        document.getElementById('valortotal').value = newValorTotal;
    });
}


function buscarDadosCripto(criptoSelecionada) {
    if (criptoSelecionada) {
        fetch("./config/buscar_dados_cripto.php?nomecripto=" + encodeURIComponent(criptoSelecionada))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("valortotal").value = data.valortotal;
                document.getElementById("valortotal").max = data.valortotal;
                document.getElementById("quantidade").value = parseFloat(data.quantidade);
                document.getElementById("quantidade").max = parseFloat(data.quantidade);
            } else {
                console.warn("Nenhum dado encontrado.");
            }
        })
        .catch(error => console.error("Erro:", error));
    }
}

function openCriptoWrite(){
    AbrirInserir();
    document.getElementById('nameCriptoSelect').style.display = 'none';
    document.getElementById('nameCriptoWrite').style.display = 'flex';
    document.getElementById('SelecCripto').disabled = true;
    document.getElementById('SelecCripto').removeAttribute('required'); 
    document.getElementById('nomeCripto').disabled = false;
    document.getElementById('nomeCripto').setAttribute('required', 'true'); 
    document.getElementById("valortotal").value = "";
    document.getElementById("valortotal").max = "";
    document.getElementById("quantidade").value = "";
    document.getElementById("quantidade").max = "";
}

function openCriptoSelect(){
    AbrirInserir();
    document.getElementById('nameCriptoSelect').style.display = 'flex';
    document.getElementById('nameCriptoWrite').style.display = 'none';
    document.getElementById('nomeCripto').disabled = true;
    document.getElementById('nomeCripto').removeAttribute('required'); 
    document.getElementById('SelecCripto').disabled = false;
    document.getElementById('SelecCripto').setAttribute('required', 'true'); 
    document.getElementById("valortotal").value = "";
    document.getElementById("valortotal").max = "";
    document.getElementById("quantidade").value = "";
    document.getElementById("quantidade").max = "";
}

function handleCriptoChange(event) {
    buscarDadosCripto(event.target.value);
}

function abrirEdicao(botao) {
    if (!botao) return; // Se o botão for nulo, sai da função
    openCriptoWrite();
    document.getElementById('form_overlay').action = "./config/alterarCripto.php"; //READ_ME remover essa linha pq era do forms, tem que ver pra onde esta indo o formulario do botao de alterar
    // Pegar os dados do botão clicado (usando atributos data-*)
    const nomeCripto = botao.getAttribute('data-nomecripto') || '';
    const dataCompra = botao.getAttribute('data-datacompra') || '';
    const descricao = botao.getAttribute('data-descricao') || '';
    const quantidade = botao.getAttribute('data-quantidade') || '0';
    const valorTotal = botao.getAttribute('data-valortotal') || '';
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
    setValue('nomeCripto', nomeCripto);
    setValue('datacompra', dataFormatada);
    setValue('descricao', descricao);
    setValue('quantidade', quantidadeFormatada);
    setValue('valortotal', valorTotal);
    setValue('tipo', tipo);
    setValue('id', id);
}



document.getElementById('novo_cripto').addEventListener('click', function(){
    openCriptoWrite();
    document.getElementById('form_overlay').action = "./config/inserirCripto.php";
    document.getElementById('hidden_check').value = "compra";
});

document.getElementById('compra_cripto').addEventListener('click', function(){
    openCriptoSelect();
    document.getElementById('form_overlay').action = "./config/inserirCripto.php";
    document.getElementById('SelecCripto').removeEventListener('change', handleCriptoChange);
    document.getElementById('hidden_check').value = "compra";
});

document.getElementById('venda_cripto').addEventListener('click', function(){
    openCriptoSelect();
    document.getElementById('form_overlay').action = "./config/inserirCripto.php";
    document.getElementById('SelecCripto').addEventListener('change', handleCriptoChange);
    const primeiroValor = document.getElementById('SelecCripto').value;
    if (primeiroValor) {
        buscarDadosCripto(primeiroValor);
    }
    QuantidadeEValorTotalVenda();
    document.getElementById('hidden_check').value = "venda";
});







let paginaAtual = 1;

document.addEventListener("DOMContentLoaded", () => {
    carregarPagina(paginaAtual);
});

function carregarPagina(pagina) {
    fetch(`./config/buscar_criptos.php?pagina=${pagina}`)
        .then(response => response.json())
        .then(data => {
            atualizarTabela(data.criptos); // Atualiza a tabela com os dados recebidos
            atualizarPaginacao(pagina, data.totalPaginas); // Atualiza os botões da paginação
            paginaAtual = pagina; // Atualiza a página atual
        })
        .catch(error => console.error("Erro ao carregar dados:", error));
}

function atualizarTabela(criptos) {
    const tbody = document.querySelector(".table-scroll tbody");
    tbody.innerHTML = ""; // Limpa a tabela antes de adicionar novos dados

    criptos.forEach(row => {
        let valorAtual = row.valorAtual ? `R$ ${parseFloat(row.valorAtual).toFixed(2).replace('.', ',')}` : "null";

        let tr = document.createElement("tr");
        tr.innerHTML = `
            <td><div class='quadrado-bola'><span class='${row.bola}'></span></div></td>
            <td class='td-img'>
                <button type='button' id='alterar_cripto' onclick='abrirEdicao(this)' 
                    data-nomecripto='${row.nomeCripto}'
                    data-datacompra='${row.dataCompra}'
                    data-descricao='${row.descricao}'
                    data-quantidade='${row.quantidade}'
                    data-valortotal='${row.valorTotal}'
                    data-tipo='${row.tipo}'
                    data-id='${row.id}'>
                    <div class='div-td-img'><img src='../icon/lapis.png'></div>
                </button>
            </td>
            <td class='td-img'>
                <form action='./config/excluirCripto.php' method='post'>
                    <input type='hidden' name='id' value='${row.id}'>
                    <input type='hidden' name='nomecripto' value='${row.nomeCripto}'>
                    <input type='hidden' name='action' value='excluir'>
                    <button type='submit'>
                        <div class='div-td-img'><img src='../icon/x.png'></div>
                    </button>
                </form>
            </td>
            <td>${row.nomeCripto}</td>
            <td>${row.dataCompra}</td>
            <td>${row.descricao}</td>
            <td>${parseFloat(row.quantidade).toFixed(10)}</td>
            <td>R$ ${parseFloat(row.valorTotal).toFixed(2).replace('.', ',')}</td>
            <td>${row.quantidadeAtual}</td>
            <td>${valorAtual}</td>
        `;
        tbody.appendChild(tr);
    });
}

function atualizarPaginacao(paginaAtual, totalPaginas) {
    const paginationContainer = document.querySelector(".pagination");
    paginationContainer.innerHTML = ""; // Limpa os botões antes de recriar

    // Botão "Anterior"
    const botaoAnterior = document.createElement("button");
    botaoAnterior.textContent = "Ant";
    botaoAnterior.disabled = paginaAtual === 1;
    botaoAnterior.onclick = () => carregarPagina(paginaAtual - 1);
    paginationContainer.appendChild(botaoAnterior);

    // Determina os números a serem exibidos
    let startPage, endPage;
    if (totalPaginas <= 5) {
        // Se houver 5 páginas ou menos, mostra todas
        startPage = 1;
        endPage = totalPaginas;
    } else if (paginaAtual <= 3) {
        // Se estiver nas primeiras páginas, mostra 1-5
        startPage = 1;
        endPage = 5;
    } else if (paginaAtual >= totalPaginas - 2) {
        // Se estiver nas últimas páginas, mostra os últimos 5
        startPage = totalPaginas - 4;
        endPage = totalPaginas;
    } else {
        // Caso normal: página atual no centro
        startPage = paginaAtual - 2;
        endPage = paginaAtual + 2;
    }

    // Criação dos botões de número de página
    for (let i = startPage; i <= endPage; i++) {
        const botaoPagina = document.createElement("button");
        botaoPagina.textContent = i;
        botaoPagina.classList.toggle("active", i === paginaAtual);
        botaoPagina.onclick = () => carregarPagina(i);
        paginationContainer.appendChild(botaoPagina);
    }

    // Botão "Próximo"
    const botaoProximo = document.createElement("button");
    botaoProximo.textContent = "Seg";
    botaoProximo.disabled = paginaAtual === totalPaginas;
    botaoProximo.onclick = () => carregarPagina(paginaAtual + 1);
    paginationContainer.appendChild(botaoProximo);
}

