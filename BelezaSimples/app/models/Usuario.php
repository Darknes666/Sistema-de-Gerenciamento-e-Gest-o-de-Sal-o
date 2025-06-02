<?php
require_once __DIR__ . '/../../config/Database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function login($email, $senha) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }

        return false;
    }

    public function cadastrar($nome, $email, $senha, $tipo = 'admin') {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nome, $email, $hash, $tipo]);
    }
}
?>
