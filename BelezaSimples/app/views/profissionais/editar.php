<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<h1>Editar Profissional</h1>
<form action="/meu_salao_app/profissionais/update" method="POST" class="bg-light p-4 rounded shadow-sm">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($profissional->id); ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($profissional->nome); ?>" required>
    </div>

    <div class="mb-3">
        <label for="especialidade" class="form-label">Especialidade:</label>
        <input type="text" class="form-control" id="especialidade" name="especialidade" value="<?php echo htmlspecialchars($profissional->especialidade); ?>">
    </div>

    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone:</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo htmlspecialchars($profissional->telefone); ?>">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($profissional->email); ?>">
    </div>

    <div class="mb-3">
        <label for="comissao_percentual" class="form-label">Comissão (%):</label>
        <input type="number" step="0.01" class="form-control" id="comissao_percentual" name="comissao_percentual" value="<?php echo htmlspecialchars($profissional->comissao_percentual); ?>">
    </div>

    <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-sync-alt me-2"></i>Atualizar Profissional
    </button>
    <a href="/meu_salao_app/profissionais/index" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</form>