<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<h1>Adicionar Novo Pacote</h1>
<form action="/meu_salao_app/pacotes/store" method="POST" class="bg-light p-4 rounded shadow-sm">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Pacote:</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição:</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label for="preco_total" class="form-label">Preço Total do Pacote:</label>
        <input type="number" step="0.01" class="form-control" id="preco_total" name="preco_total" value="0.00" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Serviços Incluídos:</label>
        <div class="border p-3 rounded" style="max-height: 200px; overflow-y: auto;">
            <?php if ($todosServicos && $todosServicos->num_rows > 0): ?>
                <?php while ($servico = $todosServicos->fetch_assoc()): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="servicos[]" value="<?php echo htmlspecialchars($servico['id']); ?>" id="servico_<?php echo htmlspecialchars($servico['id']); ?>">
                        <label class="form-check-label" for="servico_<?php echo htmlspecialchars($servico['id']); ?>">
                            <?php echo htmlspecialchars($servico['nome']); ?> (R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?>)
                        </label>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">Nenhum serviço disponível. Por favor, <a href="/meu_salao_app/servicos/adicionar">adicione serviços</a> primeiro.</p>
            <?php endif; ?>
        </div>
    </div>

    <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-save me-2"></i>Salvar Pacote
    </button>
    <a href="/meu_salao_app/pacotes/index" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</form>