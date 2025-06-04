<?php

require_once __DIR__ . '/../Models/Servico.php';

class ServicoController {
    private $servico;

    public function __construct() {
        $this->servico = new Servico();
    }

    private function loadView($viewPath, $data = []) {
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/' . $viewPath . '.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout/main.php';
    }

    public function index() {
        $stmt = $this->servico->ler();
        $num = $stmt->num_rows;

        $this->loadView('servicos/index', [
            'pageTitle' => 'Gerenciar Serviços',
            'stmt' => $stmt,
            'num' => $num
        ]);
    }

    public function adicionar() {
        $this->loadView('servicos/adicionar', [
            'pageTitle' => 'Adicionar Novo Serviço'
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->servico->nome = $_POST['nome'] ?? '';
            $this->servico->descricao = $_POST['descricao'] ?? '';
            $this->servico->preco = $_POST['preco'] ?? 0.00;
            $this->servico->duracao_minutos = $_POST['duracao_minutos'] ?? 0;

            if ($this->servico->criar()) {
                $_SESSION['message'] = "Serviço criado com sucesso!";
                header("Location: /meu_salao_app/servicos/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao criar serviço.";
                header("Location: /meu_salao_app/servicos/adicionar");
                exit();
            }
        }
        header("Location: /meu_salao_app/servicos/adicionar");
        exit();
    }

    public function editar() {
        $this->servico->id = $_GET['id'] ?? null;

        if (!$this->servico->id || !$this->servico->lerUm()) {
            $_SESSION['message'] = "Serviço não encontrado.";
            header("Location: /meu_salao_app/servicos/index");
            exit();
        }

        $this->loadView('servicos/editar', [
            'pageTitle' => 'Editar Serviço',
            'servico' => $this->servico
        ]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->servico->id = $_POST['id'] ?? null;
            if (!$this->servico->id) {
                $_SESSION['message'] = "ID do serviço não especificado para atualização.";
                header("Location: /meu_salao_app/servicos/index");
                exit();
            }

            $this->servico->nome = $_POST['nome'] ?? '';
            $this->servico->descricao = $_POST['descricao'] ?? '';
            $this->servico->preco = $_POST['preco'] ?? 0.00;
            $this->servico->duracao_minutos = $_POST['duracao_minutos'] ?? 0;

            if ($this->servico->atualizar()) {
                $_SESSION['message'] = "Serviço atualizado com sucesso!";
                header("Location: /meu_salao_app/servicos/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao atualizar serviço.";
                header("Location: /meu_salao_app/servicos/editar?id=" . $this->servico->id);
                exit();
            }
        }
        header("Location: /meu_salao_app/servicos/index");
        exit();
    }

    public function deletar() {
        $this->servico->id = $_GET['id'] ?? null;

        if (!$this->servico->id) {
            $_SESSION['message'] = "ID do serviço não especificado para exclusão.";
            header("Location: /meu_salao_app/servicos/index");
            exit();
        }

        if ($this->servico->deletar()) {
            $_SESSION['message'] = "Serviço deletado com sucesso!";
            header("Location: /meu_salao_app/servicos/index");
            exit();
        } else {
            $_SESSION['message'] = "Erro ao deletar serviço.";
            header("Location: /meu_salao_app/servicos/index");
            exit();
        }
    }
}
?>