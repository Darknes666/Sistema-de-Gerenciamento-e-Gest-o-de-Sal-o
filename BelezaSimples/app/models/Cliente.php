<?php
require_once __DIR__ . '/../../config/Database.php';

class Cliente {
    private $conn;
    private $table_name = "clientes";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Listar todos os clientes
    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Buscar um cliente pelo ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cadastrar cliente
    public function cadastrar($nome, $telefone, $email, $foto) {
        $query = "INSERT INTO " . $this->table_name . " (nome, telefone, email, foto) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nome, $telefone, $email, $foto]);
    }

    // Editar cliente
    public function editar($id, $nome, $telefone, $email, $foto) {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, telefone = ?, email = ?, foto = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nome, $telefone, $email, $foto, $id]);
    }

    // Deletar cliente
    public function deletar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>
