<?php
require_once __DIR__ . '/../Models/Agendamento.php';
require_once __DIR__ . '/../Models/Cliente.php';
require_once __DIR__ . '/../Models/Profissional.php';
require_once __DIR__ . '/../Models/Servico.php';

class AgendamentoController {
    private $agendamento;
    private $cliente;
    private $profissional;
    private $servico;

    public function __construct() {
        $this->agendamento = new Agendamento();
        $this->cliente = new Cliente();
        $this->profissional = new Profissional();
        $this->servico = new Servico();
    }

    public function index() {
        $stmt = $this->agendamento->listar();
        $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/agendamentos/index.php';
    }

    public function adicionar() {
        $clientes = $this->cliente->listar()->fetchAll(PDO::FETCH_ASSOC);
        $profissionais = $this->profissional->listar()->fetchAll(PDO::FETCH_ASSOC);
        $servicos = $this->servico->listar()->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/agendamentos/adicionar.php';
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente_id = $_POST['cliente_id'] ?? null;
            $profissional_id = $_POST['profissional_id'] ?? null;
            $servico_id = $_POST['servico_id'] ?? null;
            $data = $_POST['data'] ?? null;
            $horario = $_POST['horario'] ?? null;
            $observacoes = $_POST['observacoes'] ?? '';

            if ($cliente_id && $profissional_id && $servico_id && $data && $horario) {
                if ($this->agendamento->cadastrar($cliente_id, $profissional_id, $servico_id, $data, $horario, $observacoes)) {
                    header("Location: /agendamentos?status=success_cad");
                    exit();
                } else {
                    $error_message = "Erro ao cadastrar agendamento. Pode haver um conflito de horário para o profissional selecionado.";
                    $clientes = $this->cliente->listar()->fetchAll(PDO::FETCH_ASSOC);
                    $profissionais = $this->profissional->listar()->fetchAll(PDO::FETCH_ASSOC);
                    $servicos = $this->servico->listar()->fetchAll(PDO::FETCH_ASSOC);
                    require_once __DIR__ . '/../Views/agendamentos/adicionar.php';
                }
            } else {
                $error_message = "Todos os campos obrigatórios devem ser preenchidos.";
                $clientes = $this->cliente->listar()->fetchAll(PDO::FETCH_ASSOC);
                $profissionais = $this->profissional->listar()->fetchAll(PDO::FETCH_ASSOC);
                $servicos = $this->servico->listar()->fetchAll(PDO::FETCH_ASSOC);
                require_once __DIR__ . '/../Views/agendamentos/adicionar.php';
            }
        } else {
            header("Location: /agendamentos/adicionar");
            exit();
        }
    }

    public function editar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $agendamento = $this->agendamento->buscarPorId($id);

            if ($agendamento) {
                $clientes = $this->cliente->listar()->fetchAll(PDO::FETCH_ASSOC);
                $profissionais = $this->profissional->listar()->fetchAll(PDO::FETCH_ASSOC);
                $servicos = $this->servico->listar()->fetchAll(PDO::FETCH_ASSOC);
                $status_options = ['agendado', 'concluido', 'cancelado'];
                require_once __DIR__ . '/../Views/agendamentos/editar.php';
            } else {
                header("Location: /agendamentos?status=not_found");
                exit();
            }
        } else {
            header("Location: /agendamentos");
            exit();
        }
    }

    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $cliente_id = $_POST['cliente_id'] ?? null;
            $profissional_id = $_POST['profissional_id'] ?? null;
            $servico_id = $_POST['servico_id'] ?? null;
            $data = $_POST['data'] ?? null;
            $horario = $_POST['horario'] ?? null;
            $observacoes = $_POST['observacoes'] ?? '';
            $status = $_POST['status'] ?? 'agendado';

            if ($id && $cliente_id && $profissional_id && $servico_id && $data && $horario && $status) {
                if ($this->agendamento->editar($id, $cliente_id, $profissional_id, $servico_id, $data, $horario, $observacoes, $status)) {
                    header("Location: /agendamentos?status=success_edit");
                    exit();
                } else {
                    $error_message = "Erro ao atualizar agendamento. Pode haver um conflito de horário para o profissional selecionado ou dados inválidos.";
                    $agendamento = $this->agendamento->buscarPorId($id);
                    $clientes = $this->cliente->listar()->fetchAll(PDO::FETCH_ASSOC);
                    $profissionais = $this->profissional->listar()->fetchAll(PDO::FETCH_ASSOC);
                    $servicos = $this->servico->listar()->fetchAll(PDO::FETCH_ASSOC);
                    $status_options = ['agendado', 'concluido', 'cancelado'];
                    require_once __DIR__ . '/../Views/agendamentos/editar.php';
                }
            } else {
                $error_message = "Todos os campos obrigatórios devem ser preenchidos.";
                $agendamento = $this->agendamento->buscarPorId($id);
                $clientes = $this->cliente->listar()->fetchAll(PDO::FETCH_ASSOC);
                $profissionais = $this->profissional->listar()->fetchAll(PDO::FETCH_ASSOC);
                $servicos = $this->servico->listar()->fetchAll(PDO::FETCH_ASSOC);
                $status_options = ['agendado', 'concluido', 'cancelado'];
                require_once __DIR__ . '/../Views/agendamentos/editar.php';
            }
        } else {
            header("Location: /agendamentos");
            exit();
        }
    }

    public function deletar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->agendamento->deletar($id)) {
                header("Location: /agendamentos?status=success_del");
                exit();
            } else {
                header("Location: /agendamentos?status=error_del");
                exit();
            }
        } else {
            header("Location: /agendamentos");
            exit();
        }
    }
}