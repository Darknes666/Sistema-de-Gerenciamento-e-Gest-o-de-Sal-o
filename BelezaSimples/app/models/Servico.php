<?php
require_once __DIR__ . '/../../config/Database.php';

class Servico {
    private $conn;
    private $table_name = "servicos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar($nome, $descricao, $preco, $duracao, $foto) {
        $query = "INSERT INTO " . $this->table_name . " (nome, descricao, preco, duracao, foto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nome, $descricao, $preco, $duracao, $foto]);
    }

    public function editar($id, $nome, $descricao, $preco, $duracao, $foto) {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, descricao = ?, preco = ?, duracao = ?, foto = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nome, $descricao, $preco, $duracao, $foto, $id]);
    }

    public function deletar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>
