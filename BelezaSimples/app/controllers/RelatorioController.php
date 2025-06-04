<?php

require_once __DIR__ . '/../Models/Atendimento.php';
require_once __DIR__ . '/../Models/Servico.php';

class RelatorioController {
    private $atendimento;
    private $servico;

    public function __construct() {
        $this->atendimento = new Atendimento();
        $this->servico = new Servico();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        include __DIR__ . '/../Views/relatorios/index.php';
    }

    public function faturamentoPorPeriodo() {
        $faturamento = [];
        $data_inicio = $_GET['data_inicio'] ?? null;
        $data_fim = $_GET['data_fim'] ?? null;

        if ($data_inicio && $data_fim) {
            $query = "SELECT
                        SUM(s.preco) AS total_faturamento
                      FROM atendimentos a
                      JOIN atendimento_servicos ats ON a.id = ats.atendimento_id
                      JOIN servicos s ON ats.servico_id = s.id
                      WHERE a.status = 'Concluido'
                      AND a.data_hora BETWEEN ? AND ?";

            $stmt = $this->atendimento->conn->prepare($query);
            $data_fim_ajustada = date('Y-m-d H:i:s', strtotime($data_fim . ' 23:59:59'));
            $stmt->bind_param("ss", $data_inicio, $data_fim_ajustada);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $faturamento['total'] = $row['total_faturamento'] ?? 0;

            $query_detalhe = "SELECT
                                s.nome, SUM(s.preco) AS total_servico
                              FROM atendimentos a
                              JOIN atendimento_servicos ats ON a.id = ats.atendimento_id
                              JOIN servicos s ON ats.servico_id = s.id
                              WHERE a.status = 'Concluido'
                              AND a.data_hora BETWEEN ? AND ?
                              GROUP BY s.nome
                              ORDER BY total_servico DESC";
            $stmt_detalhe = $this->atendimento->conn->prepare($query_detalhe);
            $stmt_detalhe->bind_param("ss", $data_inicio, $data_fim_ajustada);
            $stmt_detalhe->execute();
            $faturamento['detalhes_servico'] = $stmt_detalhe->get_result();

            $query_profissional = "SELECT
                                    p.nome AS profissional_nome, SUM(s.preco) AS total_profissional
                                   FROM atendimentos a
                                   JOIN profissionais p ON a.profissional_id = p.id
                                   JOIN atendimento_servicos ats ON a.id = ats.atendimento_id
                                   JOIN servicos s ON ats.servico_id = s.id
                                   WHERE a.status = 'Concluido'
                                   AND a.data_hora BETWEEN ? AND ?
                                   GROUP BY p.nome
                                   ORDER BY total_profissional DESC";
            $stmt_profissional = $this->atendimento->conn->prepare($query_profissional);
            $stmt_profissional->bind_param("ss", $data_inicio, $data_fim_ajustada);
            $stmt_profissional->execute();
            $faturamento['detalhes_profissional'] = $stmt_profissional->get_result();

        }

        include __DIR__ . '/../Views/relatorios/faturamento.php';
    }

    public function atendimentosPorProfissional() {
        $atendimentos_por_profissional = [];
        $data_inicio = $_GET['data_inicio'] ?? null;
        $data_fim = $_GET['data_fim'] ?? null;

        if ($data_inicio && $data_fim) {
            $query = "SELECT
                        p.nome AS profissional_nome,
                        COUNT(a.