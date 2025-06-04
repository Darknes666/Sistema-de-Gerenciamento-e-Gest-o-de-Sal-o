<?php require_once __DIR__ . '/../layout/main.php'; ?>

<?php ob_start(); ?>

<div class="container">
    <h2>Editar Agendamento</h2>

    <?php if (isset($error_message)): ?>
        <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <?php if ($agendamento): ?>
    <form action="/agendamentos/atualizar" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($agendamento['id']); ?>">
        <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select id="cliente_id" name="cliente_id" class="form-control" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo htmlspecialchars($cliente['id']); ?>" 
                        <?php echo ($agendamento['cliente_id'] == $cliente['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cliente['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="profissional_id">Profissional:</label>
            <select id="profissional_id" name="profissional_id" class="form-control" required>
                <?php foreach ($profissionais as $profissional): ?>
                    <option value="<?php echo htmlspecialchars($profissional['id']); ?>" 
                        <?php echo ($agendamento['profissional_id'] == $profissional['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($profissional['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="servico_id">Serviço:</label>
            <select id="servico_id" name="servico_id" class="form-control" required>
                <?php foreach ($servicos as $servico): ?>
                    <option value="<?php echo htmlspecialchars($servico['id']); ?>" 
                        <?php echo ($agendamento['servico_id'] == $servico['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($servico['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" class="form-control" value="<?php echo htmlspecialchars($agendamento['data']); ?>" required>
        </div>
        <div class="form-group">
            <label for="horario">Horário:</label>
            <input type="time" id="horario" name="horario" class="form-control" value="<?php echo htmlspecialchars($agendamento['horario']); ?>" required>
        </div>
        <div class="form-group">
            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes" class="form-control"><?php echo htmlspecialchars($agendamento['observacoes']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" class="form-control" required>
                <?php foreach ($status_options as $status_opt): ?>
                    <option value="<?php echo htmlspecialchars($status_opt); ?>" 
                        <?php echo ($agendamento['status'] == $status_opt) ? 'selected' : ''; ?>>
                        <?php echo ucfirst(htmlspecialchars($status_opt)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Atualizar Agendamento</button>
            <a href="/agendamentos" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
    <?php else: ?>
        <p>Agendamento não encontrado.</p>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . '/../layout/main.php'; ?>