<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gerenciar Pacotes</h1>
    <a href="/meu_salao_app/pacotes/adicionar" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Adicionar Novo Pacote
    </a>
</div>

<?php if ($num > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Preço Total</th>
                    <th scope="col">Data de Criação</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                        <td>R$ <?php echo number_format($row['preco_total'], 2, ',', '.'); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['data_criacao'])); ?></td>
                        <td>
                            <a href="/meu_salao_app/pacotes/editar?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm me-1" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/meu_salao_app/pacotes/deletar?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger btn-sm" title="Deletar" onclick="return confirm('Tem certeza que deseja deletar este pacote? Esta ação é irreversível.');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning" role="alert">
        Nenhum pacote cadastrado ainda. <a href="/meu_salao_app/pacotes/adicionar" class="alert-link">Adicione um agora!</a>
    </div>
<?php endif; ?>