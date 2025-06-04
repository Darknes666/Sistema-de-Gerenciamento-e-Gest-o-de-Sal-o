<?php

require_once __DIR__ . '/../Models/Cliente.php';

class ClienteController {
    private $cliente;

    public function __construct() {
        $this->cliente = new Cliente();
    }

    private function loadView($viewPath, $data = []) {
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/' . $viewPath . '.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout/main.php';
    }

    public function index() {
        $stmt = $this->cliente->ler();
        $num = $stmt->num_rows;

        $this->loadView('clientes/index', [
            'pageTitle' => 'Gerenciar Clientes',
            'stmt' => $stmt,
            'num' => $num
        ]);
    }

    public function adicionar() {
        $this->loadView('clientes/adicionar', [
            'pageTitle' => 'Adicionar Novo Cliente'
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagem_perfil_path = null;
            if (isset($_FILES['imagem_perfil']) && $_FILES['imagem_perfil']['error'] == UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../../public/images/clientes/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['imagem_perfil']['name'], PATHINFO_EXTENSION);
                $new_file_name = uniqid('cliente_') . '.' . $file_extension;
                $upload_file_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($_FILES['imagem_perfil']['tmp_name'], $upload_file_path)) {
                    $imagem_perfil_path = 'public/images/clientes/' . $new_file_name;
                } else {
                    $_SESSION['message'] = "Erro ao fazer upload da imagem.";
                }
            }

            $this->cliente->nome = $_POST['nome'] ?? '';
            $this->cliente->telefone = $_POST['telefone'] ?? '';
            $this->cliente->email = $_POST['email'] ?? '';
            $this->cliente->imagem_perfil = $imagem_perfil_path;

            if ($this->cliente->criar()) {
                $_SESSION['message'] = "Cliente criado com sucesso!";
                header("Location: /meu_salao_app/clientes/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao criar cliente.";
                header("Location: /meu_salao_app/clientes/adicionar");
                exit();
            }
        }
        header("Location: /meu_salao_app/clientes/adicionar");
        exit();
    }

    public function editar() {
        $this->cliente->id = $_GET['id'] ?? null;

        if (!$this->cliente->id || !$this->cliente->lerUm()) {
            $_SESSION['message'] = "Cliente não encontrado.";
            header("Location: /meu_salao_app/clientes/index");
            exit();
        }

        $this->loadView('clientes/editar', [
            'pageTitle' => 'Editar Cliente',
            'cliente' => $this->cliente
        ]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cliente->id = $_POST['id'] ?? null;
            if (!$this->cliente->id) {
                $_SESSION['message'] = "ID do cliente não especificado para atualização.";
                header("Location: /meu_salao_app/clientes/index");
                exit();
            }

            $this->cliente->lerUm();
            $imagem_perfil_path = $this->cliente->imagem_perfil;

            if (isset($_FILES['imagem_perfil']) && $_FILES['imagem_perfil']['error'] == UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../../public/images/clientes/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['imagem_perfil']['name'], PATHINFO_EXTENSION);
                $new_file_name = uniqid('cliente_') . '.' . $file_extension;
                $upload_file_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($_FILES['imagem_perfil']['tmp_name'], $upload_file_path)) {
                    if ($this->cliente->imagem_perfil && file_exists(__DIR__ . '/../../' . $this->cliente->imagem_perfil)) {
                        unlink(__DIR__ . '/../../' . $this->cliente->imagem_perfil);
                    }
                    $imagem_perfil_path = 'public/images/clientes/' . $new_file_name;
                } else {
                    $_SESSION['message'] = "Erro ao mover o novo arquivo de imagem.";
                }
            }

            $this->cliente->nome = $_POST['nome'] ?? '';
            $this->cliente->telefone = $_POST['telefone'] ?? '';
            $this->cliente->email = $_POST['email'] ?? '';
            $this->cliente->imagem_perfil = $imagem_perfil_path;

            if ($this->cliente->atualizar()) {
                $_SESSION['message'] = "Cliente atualizado com sucesso!";
                header("Location: /meu_salao_app/clientes/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao atualizar cliente.";
                header("Location: /meu_salao_app/clientes/editar?id=" . $this->cliente->id);
                exit();
            }
        }
        header("Location: /meu_salao_app/clientes/index");
        exit();
    }

    public function deletar() {
        $this->cliente->id = $_GET['id'] ?? null;

        if (!$this->cliente->id) {
            $_SESSION['message'] = "ID do cliente não especificado para exclusão.";
            header("Location: /meu_salao_app/clientes/index");
            exit();
        }

        if ($this->cliente->deletar()) {
            $_SESSION['message'] = "Cliente deletado com sucesso!";
            header("Location: /meu_salao_app/clientes/index");
            exit();
        } else {
            $_SESSION['message'] = "Erro ao deletar cliente.";
            header("Location: /meu_salao_app/clientes/index");
            exit();
        }
    }
}
?>