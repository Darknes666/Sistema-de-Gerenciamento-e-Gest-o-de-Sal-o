<?php

require_once __DIR__ . '/../Models/Profissional.php';

class ProfissionalController {
    private $profissional;

    public function __construct() {
        $this->profissional = new Profissional();
    }

    private function loadView($viewPath, $data = []) {
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/' . $viewPath . '.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout/main.php';
    }

    public function index() {
        $stmt = $this->profissional->ler();
        $num = $stmt->num_rows;

        $this->loadView('profissionais/index', [
            'pageTitle' => 'Gerenciar Profissionais',
            'stmt' => $stmt,
            'num' => $num
        ]);
    }

    public function adicionar() {
        $this->loadView('profissionais/adicionar', [
            'pageTitle' => 'Adicionar Novo Profissional'
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->profissional->nome = $_POST['nome'] ?? '';
            $this->profissional->especialidade = $_POST['especialidade'] ?? '';
            $this->profissional->telefone = $_POST['telefone'] ?? '';
            $this->profissional->email = $_POST['email'] ?? '';
            $this->profissional->comissao_percentual = $_POST['comissao_percentual'] ?? 0.00;

            if ($this->profissional->criar()) {
                $_SESSION['message'] = "Profissional criado com sucesso!";
                header("Location: /meu_salao_app/profissionais/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao criar profissional.";
                header("Location: /meu_salao_app/profissionais/adicionar");
                exit();
            }
        }
        header("Location: /meu_salao_app/profissionais/adicionar");
        exit();
    }

    public function editar() {
        $this->profissional->id = $_GET['id'] ?? null;

        if (!$this->profissional->id || !$this->profissional->lerUm()) {
            $_SESSION['message'] = "Profissional não encontrado.";
            header("Location: /meu_salao_app/profissionais/index");
            exit();
        }

        $this->loadView('profissionais/editar', [
            'pageTitle' => 'Editar Profissional',
            'profissional' => $this->profissional
        ]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->profissional->id = $_POST['id'] ?? null;
            if (!$this->profissional->id) {
                $_SESSION['message'] = "ID do profissional não especificado para atualização.";
                header("Location: /meu_salao_app/profissionais/index");
                exit();
            }

            $this->profissional->nome = $_POST['nome'] ?? '';
            $this->profissional->especialidade = $_POST['especialidade'] ?? '';
            $this->profissional->telefone = $_POST['telefone'] ?? '';
            $this->profissional->email = $_POST['email'] ?? '';
            $this->profissional->comissao_percentual = $_POST['comissao_percentual'] ?? 0.00;


            if ($this->profissional->atualizar()) {
                $_SESSION['message'] = "Profissional atualizado com sucesso!";
                header("Location: /meu_salao_app/profissionais/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao atualizar profissional.";
                header("Location: /meu_salao_app/profissionais/editar?id=" . $this->profissional->id);
                exit();
            }
        }
        header("Location: /meu_salao_app/profissionais/index");
        exit();
    }

    public function deletar() {
        $this->profissional->id = $_GET['id'] ?? null;

        if (!$this->profissional->id) {
            $_SESSION['message'] = "ID do profissional não especificado para exclusão.";
            header("Location: /meu_salao_app/profissionais/index");
            exit();
        }

        if ($this->profissional->deletar()) {
            $_SESSION['message'] = "Profissional deletado com sucesso!";
            header("Location: /meu_salao_app/profissionais/index");
            exit();
        } else {
            $_SESSION['message'] = "Erro ao deletar profissional.";
            header("Location: /meu_salao_app/profissionais/index");
            exit();
        }
    }
}
?>