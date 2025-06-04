<?php

require_once __DIR__ . '/../../config/database.php';

class Servico {
    private $conn;
    private $table_name = "servicos";

    public $id;
    public $nome;
    public $descricao;
    public $preco;
    public $duracao_minutos;

    public function __construct() {
        $this->conn = getDbConnection();
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, descricao, preco, duracao_minutos) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->duracao_minutos = htmlspecialchars(strip_tags($this->duracao_minutos));

        $stmt->bind_param("ssdi", $this->nome, $this->descricao, $this->preco, $this->duracao_minutos);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function ler() {
        $query = "SELECT id, nome, descricao, preco, duracao_minutos FROM " . $this->table_name . " ORDER BY nome ASC";
        $result = $this->conn->query($query);
        return $result;
    }

    public function lerUm() {
        $query = "SELECT id, nome, descricao, preco, duracao_minutos FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'];
            $this->preco = $row['preco'];
            $this->duracao_minutos = $row['duracao_minutos'];
            return true;
        }
        return false;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, descricao = ?, preco = ?, duracao_minutos = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->duracao_minutos = htmlspecialchars(strip_tags($this->duracao_minutos));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bind_param("ssdsi", $this->nome, $this->descricao, $this->preco, $this->duracao_minutos, $this->id);

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
}
?>