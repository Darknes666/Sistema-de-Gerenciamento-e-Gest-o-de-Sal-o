<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../layout/main.php';
?>

<div class="container mt-5">
    <h1>Relatório de Faturamento por Período</h1>

    <form class="mb-4 bg-light p-4 rounded shadow-sm" method="GET" action="/meu_salao_app/relatorios/faturamento">
        <div class="row g-3">
            <div class="col-md-5">
                <label for="data_inicio" class="form-label">Data Início:</label>
                <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="<?php echo htmlspecialchars($_GET['data_inicio'] ?? ''); ?>" required>
            </div>
            <div class="col-md-5">
                <label for="data_fim" class="form-label">Data Fim:</label>
                <input type="date" class="form-control" id="data_fim" name="data_fim" value="<?php echo htmlspecialchars($_GET['data_fim'] ?? ''); ?>" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Gerar Relatório
                </button>
            </div>
        </div>
    </form>

    <?php if (isset($faturamento) && !empty($_GET['data_inicio'])): ?>
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <div>
                Faturamento total de **<?php echo htmlspecialchars(date('d/m/Y', strtotime($_GET['data_inicio']))); ?>** a **<?php echo htmlspecialchars(date('d/m/Y', strtotime($_GET['data_fim']))); ?>**:
                <h3 class="mb-0 mt-2">R$ <?php echo number_format($faturamento['total'], 2, ',', '.'); ?></h3>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Faturamento por Serviço</h4>
                <?php if ($faturamento['detalhes_servico'] && $faturamento['detalhes_servico']->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while ($detalhe = $faturamento['detalhes_servico']->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($detalhe['nome']); ?>
                                <span class="badge bg-primary rounded-pill">R$ <?php echo number_format($detalhe['total_servico'], 2, ',', '.'); ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Nenhum serviço faturado neste período.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <h4>Faturamento por Profissional</h4>
                <?php if ($faturamento['detalhes_profissional'] && $faturamento['detalhes_profissional']->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while ($detalhe = $faturamento['detalhes_profissional']->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($detalhe['profissional_nome']); ?>
                                <span class="badge bg-success rounded-pill">R$ <?php echo number_format($detalhe['total_profissional'], 2, ',', '.'); ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Nenhum faturamento por profissional neste período.</p>
                <?php endif; ?>
            </div>
        </div>

    <?php elseif (isset($_GET['data_inicio'])): ?>
        <div class="alert alert-warning" role="alert">
            Nenhum dado de faturamento encontrado para o período selecionado.
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="/meu_salao_app/relatorios" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar aos Relatórios
        </a>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>