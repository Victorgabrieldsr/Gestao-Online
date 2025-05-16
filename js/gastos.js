function formatarSalario(campo) {
  let valor = campo.value.replace(/\D/g, '');

  if (valor === '') {
    campo.value = 'R$ 0,00';
    return;
  }

  valor = Number(valor) / 100;

  campo.value = 'R$ ' + new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(valor);

  const tipo = campo.dataset.tipo;
  const mes = campo.dataset.mes;
  atualizarTotais(tipo, mes); // <-- Atualiza total após digitar
}



function moverCursor(campo){
    campo.setSelectionRange(campo.value.length, campo.value.length);
}

document.addEventListener("input", async function(e) {
  const input = e.target;
  if (input.classList.contains("salario-input")) {
    const tipo = input.dataset.tipo;
    const categoria = input.dataset.categoria;
    const mes = input.dataset.mes;
    const valor = input.value;

    console.log(`tipo: ${tipo}, categoria: ${categoria}, mes: ${mes}, valor: ${valor}`);

    try {
      const resposta = await fetch('./config/atualizar_valor_gastos.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          tipo,
          categoria,
          mes,
          valor
        })
      });
      if (resposta.ok) {
        atualizarTotais(tipo, mes); 
      }
    } catch (erro) {
      console.error('Falha na requisição:', erro);
    }
  }
});

function atualizarTotais(tipo, mes, data) {
  const inputs = document.querySelectorAll(`input.salario-input[data-tipo="${tipo}"][data-mes="${mes}"]:not([data-categoria="total"])`);
  let soma = 0;

  inputs.forEach(input => {
    const valor = parseFloat(
      input.value
        .replace(/[^0-9,]/g, '')
        .replace(/\./g, '')    
        .replace(',', '.')  
    ) || 0;
    soma += valor;
  });

  const inputTotal = document.querySelector(`input.salario-input[data-tipo="${tipo}"][data-mes="${mes}"][data-categoria="total"]`);
  // console.log(`valor: ${inputTotal.value}`);
  if (inputTotal) {
    inputTotal.value = "R$ " + new Intl.NumberFormat('pt-BR', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    }).format(soma);
  }
}

const formatarValor = (valor) => {
  return new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(valor);
};
  
document.addEventListener('DOMContentLoaded', function(){
  carregarDados();
});

function carregarDados() {
  fetch("./config/buscar_dados_gastos.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" }
  })
    .then(response => response.json())
    .then(data => {
      const container = document.querySelector("article.divisor");
      container.innerHTML = "";

      data.tipos.forEach(tipo => {
        const table = document.createElement("table");

        const thead = document.createElement("thead");
        const trHead = document.createElement("tr");
        const thTipo = document.createElement("td");
        thTipo.textContent = tipo.nome.toUpperCase();
        thTipo.className = "blue titles";
        trHead.appendChild(thTipo);

        data.meses.forEach(mes => {
          const thMes = document.createElement("td");
          thMes.textContent = mes.toUpperCase();
          thMes.className = "blue titles";
          trHead.appendChild(thMes);
        });

        thead.appendChild(trHead);
        table.appendChild(thead);

        const tbody = document.createElement("tbody");

        tipo.categorias.forEach(categoria => {
          const tr = document.createElement("tr");

          const tdCategoria = document.createElement("td");
          tdCategoria.textContent = categoria.nome.toUpperCase();
          tdCategoria.className = "blue titles";
          tr.appendChild(tdCategoria);

          data.meses.forEach(mes => {
            const valorMes = categoria.valores.find(v => v.mes === mes);
            const td = document.createElement("td");
            const input = document.createElement("input");
            input.type = "text";
            input.className = "salario-input";
            input.id = `${tipo.nome}-${categoria.nome}-${mes}`.toLowerCase();
            input.value = valorMes ? (categoria.nome.toLowerCase() === "total" ? "R$ " + formatarValor(valorMes.valor) : "R$ " + formatarValor(valorMes.valor)) : "";
            input.dataset.tipo = tipo.nome.toLowerCase();
            input.dataset.categoria = categoria.nome.toLowerCase();
            input.dataset.mes = mes.toLowerCase();

            input.setAttribute("oninput", "formatarSalario(this)");
            input.setAttribute("onclick", "moverCursor(this)");

            if (categoria.nome.toLowerCase() === "total") input.readOnly = true;

            td.appendChild(input);
            tr.appendChild(td);
          });

          tbody.appendChild(tr);
        });

        table.appendChild(tbody);
        container.appendChild(table);

        data.tipos.forEach(tipo => {
          data.meses.forEach(mes => {
            atualizarTotais(tipo.nome.toLowerCase(), mes.toLowerCase());
          });
        });
        
      });

    })
    .catch(err => console.log("Erro ao carregar dados:", err));
}
