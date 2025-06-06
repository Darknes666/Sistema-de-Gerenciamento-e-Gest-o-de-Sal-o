<?php
require_once __DIR__ . '/../../../config/Database.php';

class Agendamento {
    private $conn;
    private $table_name = "agendamentos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function buscarPorId($id) {
        $query = "SELECT a.*, 
                         c.nome AS cliente_nome, 
                         p.nome AS profissional_nome, 
                         s.nome AS servico_nome 
                  FROM " . $this->table_name . " a
                  JOIN clientes c ON a.cliente_id = c.id
                  JOIN profissionais p ON a.profissional_id = p.id
                  JOIN servicos s ON a.servico_id = s.id
                  WHERE a.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listar() {
        $query = "SELECT a.*, 
                         c.nome AS cliente_nome, 
                         p.nome AS profissional_nome, 
                         s.nome AS servico_nome 
                  FROM " . $this->table_name . " a
                  JOIN clientes c ON a.cliente_id = c.id
                  JOIN profissionais p ON a.profissional_id = p.id
                  JOIN servicos s ON a.servico_id = s.id
                  ORDER BY a.data DESC, a.horario ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function verificarConflito($profissional_id, $data, $horario, $exclude_id = null) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE profissional_id = ? AND data = ? AND horario = ? AND status = 'agendado'";
        
        if ($exclude_id) {
            $query .= " AND id != ?";
        }
        
        $stmt = $this->conn->prepare($query);
        $params = [$profissional_id, $data, $horario];
        if ($exclude_id) {
            $params[] = $exclude_id;
        }
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    public function cadastrar($cliente_id, $profissional_id, $servico_id, $data, $horario, $observacoes) {
        if ($this->verificarConflito($profissional_id, $data, $horario)) {
            return false; 
        }

        $query = "INSERT INTO " . $this->table_name . " 
                  (cliente_id, profissional_id, servico_id, data, horario, observacoes, status) 
                  VALUES (?, ?, ?, ?, ?, ?, 'agendado')";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$cliente_id, $profissional_id, $servico_id, $data, $horario, $observacoes]);
    }

    public function editar($id, $cliente_id, $profissional_id, $servico_id, $data, $horario, $observacoes, $status) {
        if ($this->verificarConflito($profissional_id, $data, $horario, $id)) {
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

    public function deletar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}