<?php
require_once __DIR__ . '/../../config/Database.php';

class Agendamento {
    private $conn;
    private $table_name = "agendamentos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Listar todos os agendamentos
    public function listar() {
        $query = "SELECT a.*, 
                        c.nome AS cliente_nome, 
                        p.nome AS profissional_nome, 
                        s.nome AS servico_nome 
                  FROM " . $this->table_name . " a
                  JOIN clientes c ON a.cliente_id = c.id
                  JOIN profissionais p ON a.profissional_id = p.id
                  JOIN servicos s ON a.servico_id = s.id
                  ORDER BY a.data, a.horario";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Verificar conflito de horário
    public function verificarConflito($profissional_id, $data, $horario) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE profissional_id = ? AND data = ? AND horario = ? AND status = 'agendado'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$profissional_id, $data, $horario]);
        return $stmt->rowCount() > 0;
    }

    // Cadastrar agendamento
    public function cadastrar($cliente_id, $profissional_id, $servico_id, $data, $horario, $observacoes) {
        if ($this->verificarConflito($profissional_id, $data, $horario)) {
            return false; // horário ocupado
        }

        $query = "INSERT INTO " . $this->table_name . " 
                  (cliente_id, profissional_id, servico_id, data, horario, observacoes) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$cliente_id, $profissional_id, $servico_id, $data, $horario, $observacoes]);
    }

    // Editar agendamento
    public function editar($id, $cliente_id, $profissional_id, $servico_id, $data, $horario, $observacoes, $status) {
        if ($this->verificarConflito($profissional_id, $data, $horario)) {
            return false;
        }

        $query = "UPDATE " . $this->table_name . " 
                  SET cliente_id = ?, profissional_id = ?, servico_id = ?, 
                      data = ?, horario = ?, observacoes = ?, status = ? 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $cliente_id, $profissional_id, $servico_id,
            $data, $horario, $observacoes, $status, $id
        ]);
    }

    // Deletar agendamento
    public function deletar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>
