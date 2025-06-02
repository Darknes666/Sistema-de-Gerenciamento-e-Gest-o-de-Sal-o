<?php
class Database {
    private $host = "localhost";
    private $db_name = "nome_do_banco";
    private $username = "usuario";
    private $password = "senha";
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES utf8");
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            exit;
        }
        return $this->conn;
    }
}
?>
