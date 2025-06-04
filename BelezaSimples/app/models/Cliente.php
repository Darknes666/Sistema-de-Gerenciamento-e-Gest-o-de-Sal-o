<?php

require_once __DIR__ . '/../../config/database.php';

class Cliente {
    private $conn;
    private $table_name = "clientes";

    public $id;
    public $nome;
    public $telefone;
    public $email;
    public $imagem_perfil;
    public $data_cadastro;

    public function __construct() {
        $this->conn = getDbConnection();
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, telefone, email, imagem_perfil) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->imagem_perfil = htmlspecialchars(strip_tags($this->imagem_perfil));

        $stmt->bind_param("ssss", $this->nome, $this->telefone, $this->email, $this->imagem_perfil);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function ler() {
        $query = "SELECT id, nome, telefone, email, imagem_perfil, data_cadastro FROM " . $this->table_name . " ORDER BY data_cadastro DESC";
        $result = $this->conn->query($query);
        return $result;
    }

    public function lerUm() {
        $query = "SELECT id, nome, telefone, email, imagem_perfil, data_cadastro FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $this->nome = $row['nome'];
            $this->telefone = $row['telefone'];
            $this->email = $row['email'];
            $this->imagem_perfil = $row['imagem_perfil'];
            $this->data_cadastro = $row['data_cadastro'];
            return true;
        }
        return false;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, telefone = ?, email = ?, imagem_perfil = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->imagem_perfil = htmlspecialchars(strip_tags($this->imagem_perfil));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bind_param("ssssi", $this->nome, $this->telefone, $this->email, $this->imagem_perfil, $this->id);

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