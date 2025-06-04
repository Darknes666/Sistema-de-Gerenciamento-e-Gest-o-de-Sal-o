<?php

require_once __DIR__ . '/../../config/database.php';

class Profissional {
    private $conn;
    private $table_name = "profissionais";

    public $id;
    public $nome;
    public $especialidade;
    public $telefone;
    public $email;
    public $comissao_percentual;

    public function __construct() {
        $this->conn = getDbConnection();
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, especialidade, telefone, email, comissao_percentual) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->especialidade = htmlspecialchars(strip_tags($this->especialidade));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->comissao_percentual = htmlspecialchars(strip_tags($this->comissao_percentual));

        $stmt->bind_param("ssssd", $this->nome, $this->especialidade, $this->telefone, $this->email, $this->comissao_percentual);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function ler() {
        $query = "SELECT id, nome, especialidade, telefone, email, comissao_percentual FROM " . $this->table_name . " ORDER BY nome ASC";
        $result = $this->conn->query($query);
        return $result;
    }

    public function lerUm() {
        $query = "SELECT id, nome, especialidade, telefone, email, comissao_percentual FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $this->nome = $row['nome'];
            $this->especialidade = $row['especialidade'];
            $this->telefone = $row['telefone'];
            $this->email = $row['email'];
            $this->comissao_percentual = $row['comissao_percentual'];
            return true;
        }
        return false;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, especialidade = ?, telefone = ?, email = ?, comissao_percentual = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->especialidade = htmlspecialchars(strip_tags($this->especialidade));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->comissao_percentual = htmlspecialchars(strip_tags($this->comissao_percentual));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bind_param("ssssdi", $this->nome, $this->especialidade, $this->telefone, $this->email, $this->comissao_percentual, $this->id);

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