<?php

require_once __DIR__ . '/../Models/Pacote.php';
require_once __DIR__ . '/../Models/Servico.php';

class PacoteController {
    private $pacote;
    private $servico;

    public function __construct() {
        $this->pacote = new Pacote();
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
        $stmt = $this->pacote->ler();
        $num = $stmt->num_rows;

        $this->loadView('pacotes/index', [
            'pageTitle' => 'Gerenciar Pacotes',
            'stmt' => $stmt,
            'num' => $num
        ]);
    }

    public function adicionar() {
        $todosServicos = $this->servico->ler();
        $this->loadView('pacotes/adicionar', [
            'pageTitle' => 'Adicionar Novo Pacote',
            'todosServicos' => $todosServicos
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pacote->nome = $_POST['nome'] ?? '';
            $this->pacote->descricao = $_POST['descricao'] ?? '';
            $this->pacote->preco_total = $_POST['preco_total'] ?? 0.00;
            $servicosSelecionados = $_POST['servicos'] ?? [];

            if ($this->pacote->criar()) {
                $pacote_id = $this->pacote->id;
                foreach ($servicosSelecionados as $servico_id) {
                    $this->pacote->adicionarServicoAoPacote($pacote_id, $servico_id);
                }
                $_SESSION['message'] = "Pacote criado com sucesso!";
                header("Location: /meu_salao_app/pacotes/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao criar pacote.";
                header("Location: /meu_salao_app/pacotes/adicionar");
                exit();
            }
        }
        header("Location: /meu_salao_app/pacotes/adicionar");
        exit();
    }

    public function editar() {
        $this->pacote->id = $_GET['id'] ?? null;

        if (!$this->pacote->id || !$this->pacote->lerUm()) {
            $_SESSION['message'] = "Pacote não encontrado.";
            header("Location: /meu_salao_app/pacotes/index");
            exit();
        }

        $servicosDoPacote = $this->pacote->getServicosDoPacote($this->pacote->id);
        $servicosAtuaisIds = [];
        while($row = $servicosDoPacote->fetch_assoc()) {
            $servicosAtuaisIds[] = $row['id'];
        }

        $todosServicos = $this->servico->ler();

        $this->loadView('pacotes/editar', [
            'pageTitle' => 'Editar Pacote',
            'pacote' => $this->pacote,
            'todosServicos' => $todosServicos,
            'servicosAtuaisIds' => $servicosAtuaisIds
        ]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pacote->id = $_POST['id'] ?? null;
            if (!$this->pacote->id) {
                $_SESSION['message'] = "ID do pacote não especificado para atualização.";
                header("Location: /meu_salao_app/pacotes/index");
                exit();
            }

            $this->pacote->nome = $_POST['nome'] ?? '';
            $this->pacote->descricao = $_POST['descricao'] ?? '';
            $this->pacote->preco_total = $_POST['preco_total'] ?? 0.00;
            $servicosSelecionados = $_POST['servicos'] ?? [];

            if ($this->pacote->atualizar()) {
                $this->pacote->limparServicosDoPacote($this->pacote->id);
                foreach ($servicosSelecionados as $servico_id) {
                    $this->pacote->adicionarServicoAoPacote($this->pacote->id, $servico_id);
                }
                $_SESSION['message'] = "Pacote atualizado com sucesso!";
                header("Location: /meu_salao_app/pacotes/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao atualizar pacote.";
                header("Location: /meu_salao_app/pacotes/editar?id=" . $this->pacote->id);
                exit();
            }
        }
        header("Location: /meu_salao_app/pacotes/index");
        exit();
    }

    public function deletar() {
        $this->pacote->id = $_GET['id'] ?? null;

        if (!$this->pacote->id) {
            $_SESSION['message'] = "ID do pacote não especificado para exclusão.";
            header("Location: /meu_salao_app/pacotes/index");
            exit();
        }

        if ($this->pacote->deletar()) {
            $_SESSION['message'] = "Pacote deletado com sucesso!";
            header("Location: /meu_salao_app/pacotes/index");
            exit();
        } else {
            $_SESSION['message'] = "Erro ao deletar pacote.";
            header("Location: /meu_salao_app/pacotes/index");
            exit();
        }
    }
}
?>