<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/pages/configuracao.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Configurações de perfil</h2>
            <p>Atualize suas informações pessoais e foto de perfil.</p>
            <button>Editar perfil</button>
        </div>

        <div class="card">
            <h2>Rentabilidade Provento</h2>
            <div class="input-group">
                <label for="rentability">Rentabilidade (%)</label>
                <input type="number" id="rentability" placeholder="Insira o valor">
            </div>
            <button>Atualizar rentabilidade</button>
        </div>

        <div class="card">
            <h2>Modo escuro</h2>
            <div class="toggle-switch">
                <input type="checkbox" id="dark-mode-toggle">
                <label for="dark-mode-toggle">Habilitar Modo Escuro</label>
            </div>
        </div>
    </div>
</body>
</html>
