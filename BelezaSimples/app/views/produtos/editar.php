<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<h1>Editar Produto</h1>
<form action="/meu_salao_app/produtos/update" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($produto->id); ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($produto->nome); ?>" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição:</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3"><?php echo htmlspecialchars($produto->descricao); ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="preco_compra" class="form-label">Preço de Compra:</label>
            <input type="number" step="0.01" class="form-control" id="preco_compra" name="preco_compra" value="<?php echo htmlspecialchars($produto->preco_compra); ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="preco_venda" class="form-label">Preço de Venda:</label>
            <input type="number" step="0.01" class="form-control" id="preco_venda" name="preco_venda" value="<?php echo htmlspecialchars($produto->preco_venda); ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="estoque" class="form-label">Estoque:</label>
            <input type="number" class="form-control" id="estoque" name="estoque" value="<?php echo htmlspecialchars($produto->estoque); ?>" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="imagem_produto_atual" class="form-label">Imagem do Produto Atual:</label>
        <?php if ($produto->imagem_produto): ?>
            <img src="/meu_salao_app/<?php echo htmlspecialchars($produto->imagem_produto); ?>" alt="Imagem Atual" class="img-thumbnail d-block mb-2" style="width: 150px; height: 150px; object-fit: cover;">
        <?php else: ?>
            <p class="text-muted">Nenhuma imagem de produto atual.</p>
        <?php endif; ?>
        <label for="imagem_produto" class="form-label">Nova Imagem do Produto (opcional):</label>
        <input type="file" class="form-control" id="imagem_produto" name="imagem_produto" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-sync-alt me-2"></i>Atualizar Produto
    </button>
    <a href="/meu_salao_app/produtos/index" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</form>