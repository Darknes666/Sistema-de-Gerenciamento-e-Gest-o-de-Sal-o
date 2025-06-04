<?php

require_once __DIR__ . '/../../config/database.php';

class Pacote {
    private $conn;
    private $table_name = "pacotes";
    private $table_pacote_servicos = "pacote_servicos";

    public $id;
    public $nome;
    public $descricao;
    public $preco_total;
    public $data_criacao;

    public function __construct() {
        $this->conn = getDbConnection();
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, descricao, preco_total) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco_total = htmlspecialchars(strip_tags($this->preco_total));

        $stmt->bind_param("ssd", $this->nome, $this->descricao, $this->preco_total);

        if ($stmt->execute()) {
            $this->id = $this->conn->insert_id;
            return true;
        }
        return false;
    }

    public function ler() {
        $query = "SELECT id, nome, descricao, preco_total, data_criacao FROM " . $this->table_name . " ORDER BY nome ASC";
        $result = $this->conn->query($query);
        return $result;
    }

    public function lerUm() {
        $query = "SELECT id, nome, descricao, preco_total, data_criacao FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'];
            $this->preco_total = $row['preco_total'];
            $this->data_criacao = $row['data_criacao'];
            return true;
        }
        return false;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, descricao = ?, preco_total = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco_total = htmlspecialchars(strip_tags($this->preco_total));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bind_param("ssdi", $this->nome, $this->descricao, $this->preco_total, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deletar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function adicionarServicoAoPacote($pacote_id, $servico_id) {
        $query = "INSERT INTO " . $this->table_pacote_servicos . " (pacote_id, servico_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $pacote_id, $servico_id);
        return $stmt->execute();
    }

    public function removerServicoDoPacote($pacote_id, $servico_id) {
        $query = "DELETE FROM " . $this->table_pacote_servicos . " WHERE pacote_id = ? AND servico_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $pacote_id, $servico_id);
        return $stmt->execute();
    }

    public function getServicosDoPacote($pacote_id) {
        $query = "SELECT s.id, s.nome, s.preco, s.duracao_minutos FROM servicos s JOIN " . $this->table_pacote_servicos . " ps ON s.id = ps.servico_id WHERE ps.pacote_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $pacote_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function limparServicosDoPacote($pacote_id) {
        $query = "DELETE FROM " . $this->table_pacote_servicos . " WHERE pacote_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $pacote_id);
        return $stmt->execute();
    }
}
?>