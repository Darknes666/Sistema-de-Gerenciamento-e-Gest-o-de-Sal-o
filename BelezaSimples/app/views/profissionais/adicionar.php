<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<h1>Adicionar Novo Profissional</h1>
<form action="/meu_salao_app/profissionais/store" method="POST" class="bg-light p-4 rounded shadow-sm">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>

    <div class="mb-3">
        <label for="especialidade" class="form-label">Especialidade:</label>
        <input type="text" class="form-control" id="especialidade" name="especialidade">
    </div>

    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone:</label>
        <input type="text" class="form-control" id="telefone" name="telefone">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>

    <div class="mb-3">
        <label for="comissao_percentual" class="form-label">Comissão (%):</label>
        <input type="number" step="0.01" class="form-control" id="comissao_percentual" name="comissao_percentual" value="0.00">
    </div>

    <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-save me-2"></i>Salvar Profissional
    </button>
    <a href="/meu_salao_app/profissionais/index" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</form>