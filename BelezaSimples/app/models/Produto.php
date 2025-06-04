<?php

require_once __DIR__ . '/../../config/database.php';

class Produto {
    private $conn;
    private $table_name = "produtos";

    public $id;
    public $nome;
    public $descricao;
    public $preco_compra;
    public $preco_venda;
    public $estoque;
    public $imagem_produto;

    public function __construct() {
        $this->conn = getDbConnection();
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, descricao, preco_compra, preco_venda, estoque, imagem_produto) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco_compra = htmlspecialchars(strip_tags($this->preco_compra));
        $this->preco_venda = htmlspecialchars(strip_tags($this->preco_venda));
        $this->estoque = htmlspecialchars(strip_tags($this->estoque));
        $this->imagem_produto = htmlspecialchars(strip_tags($this->imagem_produto));

        $stmt->bind_param("ssddis", $this->nome, $this->descricao, $this->preco_compra, $this->preco_venda, $this->estoque, $this->imagem_produto);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function ler() {
        $query = "SELECT id, nome, descricao, preco_compra, preco_venda, estoque, imagem_produto FROM " . $this->table_name . " ORDER BY nome ASC";
        $result = $this->conn->query($query);
        return $result;
    }

    public function lerUm() {
        $query = "SELECT id, nome, descricao, preco_compra, preco_venda, estoque, imagem_produto FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'];
            $this->preco_compra = $row['preco_compra'];
            $this->preco_venda = $row['preco_venda'];
            $this->estoque = $row['estoque'];
            $this->imagem_produto = $row['imagem_produto'];
            return true;
        }
        return false;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, descricao = ?, preco_compra = ?, preco_venda = ?, estoque = ?, imagem_produto = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco_compra = htmlspecialchars(strip_tags($this->preco_compra));
        $this->preco_venda = htmlspecialchars(strip_tags($this->preco_venda));
        $this->estoque = htmlspecialchars(strip_tags($this->estoque));
        $this->imagem_produto = htmlspecialchars(strip_tags($this->imagem_produto));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bind_param("ssddisi", $this->nome, $this->descricao, $this->preco_compra, $this->preco_venda, $this->estoque, $this->imagem_produto, $this->id);

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