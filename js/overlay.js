
// function abrirOverlay(){
//     let overlay2 = document.querySelector('#overlay2');
//     overlay2.style.display = 'flex';
// }

// function cancelarOverlay() {
//     let overlay2 = document.querySelector('#overlay2');
//     overlay2.style.display = 'none';
// }

const checkboxes = document.querySelectorAll('.formhidden input[type="checkbox"]');
  
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                checkboxes.forEach(cb => {
                    if (cb !== checkbox) cb.checked = false;
                });
            }
        });
});


function togglePorcentoAno() {
    const categoria = document.getElementById('categoria').value;
    const porcentoAnoContainer = document.getElementById('porcentoAno-container');

    if (categoria === 'Fundo de Investimento') {
        porcentoAnoContainer.style.display = 'block';
    } else {
        porcentoAnoContainer.style.display = 'none';
    }
}

// function toggleCheckBoxCripto() {
//     const checkboxes = document.getElementsByName('check');
//     const selectedCheckbox = Array.from(checkboxes).find(checkbox => checkbox.checked);
//     const selectedValue = selectedCheckbox ? selectedCheckbox.value : '';

    // const nameCriptoSelect = document.getElementById('nameCriptoSelect');
    // const nameCriptoWrite = document.getElementById('nameCriptoWrite');
    // const selectCripto = document.getElementById('SelecCripto');
    // const inputCripto = document.getElementById('nomeCripto');

//     if (selectedValue === 'venda') {
//         // Mostra o select e esconde o input
//         nameCriptoSelect.style.display = 'flex';
//         nameCriptoWrite.style.display = 'none';

        // inputCripto.disabled = true;
        // inputCripto.removeAttribute('required'); 
        // selectCripto.disabled = false;
        // selectCripto.setAttribute('required', 'true'); 

//         // Se já houver uma opção selecionada, busca os dados
//         if (selectCripto.value) {
//             buscarDadosCripto(selectCripto.value);
//         }
//     } else {
//         // Mostra o input e esconde o select
        // nameCriptoSelect.style.display = 'none';
        // nameCriptoWrite.style.display = 'flex';

//         // Desativa o select e ativa o input
        // selectCripto.disabled = true;
        // selectCripto.removeAttribute('required'); 
        // inputCripto.disabled = false;
        // inputCripto.setAttribute('required', 'true'); 

//         // Limpa os campos
//         document.getElementById('datacompra').value = '';
//         document.getElementById('valortotal').value = '';
//         document.getElementById('quantidade').value = '';
//         document.getElementById('descricao').value = '';
//     }
// }








