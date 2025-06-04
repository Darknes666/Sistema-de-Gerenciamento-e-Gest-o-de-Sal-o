<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../layout/main.php';
?>

<div class="container mt-5">
    <h1>Relatório de Atendimentos por Profissional</h1>

    <form class="mb-4 bg-light p-4 rounded shadow-sm" method="GET" action="/meu_salao_app/relatorios/profissionais">
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

    <?php if (isset($atendimentos_por_profissional) && !empty($_GET['data_inicio'])): ?>
        <?php if ($atendimentos_por_profissional->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Profissional</th>
                            <th>Total de Atendimentos</th>
                            <th>Clientes Atendidos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $atendimentos_por_profissional->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['profissional_nome']); ?></td>
                                <td><span class="badge bg-info rounded-pill"><?php echo htmlspecialchars($row['total_atendimentos']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['clientes_atendidos'] ?? 'Nenhum'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Nenhum atendimento encontrado para o período e profissionais selecionados.
            </div>
        <?php endif; ?>
    <?php elseif (isset($_GET['data_inicio'])): ?>
        <div class="alert alert-warning" role="alert">
            Por favor, selecione um período para gerar o relatório.
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="/meu_salao_app/relatorios" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar aos Relatórios
        </a>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>