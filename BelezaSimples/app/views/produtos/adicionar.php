<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<h1>Adicionar Novo Produto</h1>
<form action="/meu_salao_app/produtos/store" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição:</label>
        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="preco_compra" class="form-label">Preço de Compra:</label>
            <input type="number" step="0.01" class="form-control" id="preco_compra" name="preco_compra" value="0.00" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="preco_venda" class="form-label">Preço de Venda:</label>
            <input type="number" step="0.01" class="form-control" id="preco_venda" name="preco_venda" value="0.00" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="estoque" class="form-label">Estoque:</label>
            <input type="number" class="form-control" id="estoque" name="estoque" value="0" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="imagem_produto" class="form-label">Imagem do Produto:</label>
        <input type="file" class="form-control" id="imagem_produto" name="imagem_produto" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary me-2">
        <i class="fas fa-save me-2"></i>Salvar Produto
    </button>
    <a href="/meu_salao_app/produtos/index" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</form>