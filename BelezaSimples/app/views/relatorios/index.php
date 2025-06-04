<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../layout/main.php';
?>

<div class="container mt-5">
    <h1>Relatórios do Salão</h1>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Relatório de Faturamento por Período</h5>
                    <p class="card-text">Visualize o faturamento total do salão em um determinado intervalo de datas.</p>
                    <a href="/meu_salao_app/relatorios/faturamento" class="btn btn-primary">
                        <i class="fas fa-money-bill-wave me-2"></i>Ver Relatório
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Relatório de Atendimentos por Profissional</h5>
                    <p class="card-text">Analise a quantidade de atendimentos realizados por cada profissional.</p>
                    <a href="/meu_salao_app/relatorios/profissionais" class="btn btn-primary">
                        <i class="fas fa-user-tie me-2"></i>Ver Relatório
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>