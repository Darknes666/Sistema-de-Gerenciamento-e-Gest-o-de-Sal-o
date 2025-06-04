<?php require_once __DIR__ . '/../layout/main.php'; ?>

<?php ob_start(); ?>

<div class="container">
    <h2>Agendamentos</h2>

    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'success_cad') {
            echo '<div class="message success">Agendamento cadastrado com sucesso!</div>';
        } elseif ($_GET['status'] == 'success_edit') {
            echo '<div class="message success">Agendamento atualizado com sucesso!</div>';
        } elseif ($_GET['status'] == 'success_del') {
            echo '<div class="message success">Agendamento excluído com sucesso!</div>';
        } elseif ($_GET['status'] == 'error_del') {
            echo '<div class="message error">Erro ao excluir agendamento.</div>';
        } elseif ($_GET['status'] == 'not_found') {
            echo '<div class="message error">Agendamento não encontrado.</div>';
        }
    }
    ?>

    <p><a href="/agendamentos/adicionar" class="btn btn-success">Novo Agendamento</a></p>

    <?php if (empty($agendamentos)): ?>
        <p>Nenhum agendamento encontrado.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Profissional</th>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Status</th>
                    <th>Observações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($agendamento['id']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['cliente_nome']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['profissional_nome']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['servico_nome']); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($agendamento['data']))); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['horario']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['status']); ?></td>
                        <td><?php echo htmlspecialchars($agendamento['observacoes']); ?></td>
                        <td>
                            <a href="/agendamentos/editar?id=<?php echo $agendamento['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="/agendamentos/deletar?id=<?php echo $agendamento['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este agendamento?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . '/../layout/main.php'; ?>