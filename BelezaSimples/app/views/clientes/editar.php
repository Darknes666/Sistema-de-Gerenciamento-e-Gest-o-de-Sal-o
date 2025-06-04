<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<h1>Editar Cliente</h1>
<form action="/meu_salao_app/clientes/update" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($cliente->id); ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($cliente->nome); ?>" required>
    </div>

    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone:</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo htmlspecialchars($cliente->telefone); ?>">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($cliente->email); ?>">
    </div>

    <div class="mb-3">
        <label for="imagem_perfil_atual" class="form-label">Imagem de Perfil Atual:</label>
        <?php if ($cliente->imagem_perfil): ?>
            <img src="/meu_salao_app/<?php echo htmlspecialchars($cliente->imagem_perfil); ?>" alt="Imagem Atual" class="img-thumbnail d-block mb-2" style="width: 150px; height: 150px; object-fit: cover;">
        <?php else: ?>
            <p class="text-muted">Nenhuma imagem de perfil atual.</p>
        <?php endif; ?>
        <label for="imagem_perfil" class="form-label">Nova Imagem de Perfil (opcional):</label>
        <input type="file" class="form-control" id="imagem_perfil" name="imagem_perfil" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-sync-alt me-2"></i>Atualizar Cliente
    </button>
    <a href="/meu_salao_app/clientes/index" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</form>