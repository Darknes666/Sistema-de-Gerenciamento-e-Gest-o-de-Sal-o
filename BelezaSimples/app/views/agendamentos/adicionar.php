<?php require_once __DIR__ . '/../layout/main.php'; ?>

<?php ob_start(); ?>

<div class="container">
    <h2>Cadastrar Novo Agendamento</h2>

    <?php if (isset($error_message)): ?>
        <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form action="/agendamentos/salvar" method="POST">
        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select id="cliente_id" name="cliente_id" class="form-control" required>
                <option value="">Selecione um cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo htmlspecialchars($cliente['id']); ?>" <?php echo (isset($_POST['cliente_id']) && $_POST['cliente_id'] == $cliente['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cliente['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="profissional_id">Profissional:</label>
            <select id="profissional_id" name="profissional_id" class="form-control" required>
                <option value="">Selecione um profissional</option>
                <?php foreach ($profissionais as $profissional): ?>
                    <option value="<?php echo htmlspecialchars($profissional['id']); ?>" <?php echo (isset($_POST['profissional_id']) && $_POST['profissional_id'] == $profissional['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($profissional['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="servico_id">Serviço:</label>
            <select id="servico_id" name="servico_id" class="form-control" required>
                <option value="">Selecione um serviço</option>
                <?php foreach ($servicos as $servico): ?>
                    <option value="<?php echo htmlspecialchars($servico['id']); ?>" <?php echo (isset($_POST['servico_id']) && $_POST['servico_id'] == $servico['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($servico['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" class="form-control" value="<?php echo htmlspecialchars($_POST['data'] ?? date('Y-m-d')); ?>" required>
        </div>
        <div class="form-group">
            <label for="horario">Horário:</label>
            <input type="time" id="horario" name="horario" class="form-control" value="<?php echo htmlspecialchars($_POST['horario'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes" class="form-control"><?php echo htmlspecialchars($_POST['observacoes'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Cadastrar Agendamento</button>
            <a href="/agendamentos" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . '/../layout/main.php'; ?>