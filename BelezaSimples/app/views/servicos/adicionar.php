<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<h1>Adicionar Novo Serviço</h1>
<form action="/meu_salao_app/servicos/store" method="POST" class="bg-light p-4 rounded shadow-sm">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição:</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="preco" class="form-label">Preço:</label>
            <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="0.00" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="duracao_minutos" class="form-label">Duração (minutos):</label>
            <input type="number" class="form-control" id="duracao_minutos" name="duracao_minutos" value="30" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-save me-2"></i>Salvar Serviço
    </button>
    <a href="/meu_salao_app/servicos/index" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</form>