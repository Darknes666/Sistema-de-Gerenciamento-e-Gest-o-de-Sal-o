<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../app/Controllers/ClienteController.php';
require_once __DIR__ . '/../app/Controllers/ProfissionalController.php';
require_once __DIR__ . '/../app/Controllers/ProdutoController.php';
require_once __DIR__ . '/../app/Controllers/ServicoController.php';
require_once __DIR__ . '/../app/Controllers/PacoteController.php';
require_once __DIR__ . '/../app/Controllers/AtendimentoController.php';
require_once __DIR__ . '/../app/Controllers/RelatorioController.php';
require_once __DIR__ . '/../app/Controllers/AgendamentoController.php'; 

$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/meu_salao_app';
$request_uri = str_replace($base_path, '', $request_uri);
$request_uri = strtok($request_uri, '?');
$request_uri = rtrim($request_uri, '/');

$clienteController = new ClienteController();
$profissionalController = new ProfissionalController();
$produtoController = new ProdutoController();
$servicoController = new ServicoController();
$pacoteController = new PacoteController();
$atendimentoController = new AtendimentoController();
$relatorioController = new RelatorioController();
$agendamentoController = new AgendamentoController(); 

switch (true) {
    case $request_uri === '' || $request_uri === '/':
        $pageTitle = 'Dashboard';
        ob_start(); 
        echo "<h1>Bem-vindo ao Meu Salão APP!</h1>";
        echo "<p>Use o menu lateral para navegar e gerenciar seu salão.</p>";
        $content = ob_get_clean(); 
        require_once __DIR__ . '/../app/Views/layout/main.php'; 
        break;

    case $request_uri === '/clientes' || $request_uri === '/clientes/index':
        $clienteController->index();
        break;
    case $request_uri === '/clientes/adicionar':
        $clienteController->adicionar();
        break;
    case $request_uri === '/clientes/store':
        $clienteController->store();
        break;
    case preg_match('/^\/clientes\/editar\/(\d+)$/', $request_uri, $matches):
        $clienteController->editar(['id' => $matches[1]]);
        break;
    case $request_uri === '/clientes/update':
        $clienteController->update();
        break;
    case preg_match('/^\/clientes\/deletar\/(\d+)$/', $request_uri, $matches):
        $clienteController->deletar(['id' => $matches[1]]);
        break;

    case $request_uri === '/profissionais' || $request_uri === '/profissionais/index':
        $profissionalController->index();
        break;
    case $request_uri === '/profissionais/adicionar':
        $profissionalController->adicionar();
        break;
    case $request_uri === '/profissionais/store':
        $profissionalController->store();
        break;
    case preg_match('/^\/profissionais\/editar\/(\d+)$/', $request_uri, $matches):
        $profissionalController->editar(['id' => $matches[1]]);
        break;
    case $request_uri === '/profissionais/update':
        $profissionalController->update();
        break;
    case preg_match('/^\/profissionais\/deletar\/(\d+)$/', $request_uri, $matches):
        $profissionalController->deletar(['id' => $matches[1]]);
        break;

    case $request_uri === '/produtos' || $request_uri === '/produtos/index':
        $produtoController->index();
        break;
    case $request_uri === '/produtos/adicionar':
        $produtoController->adicionar();
        break;
    case $request_uri === '/produtos/store':
        $produtoController->store();
        break;
    case preg_match('/^\/produtos\/editar\/(\d+)$/', $request_uri, $matches):
        $produtoController->editar(['id' => $matches[1]]);
        break;
    case $request_uri === '/produtos/update':
        $produtoController->update();
        break;
    case preg_match('/^\/produtos\/deletar\/(\d+)$/', $request_uri, $matches):
        $produtoController->deletar(['id' => $matches[1]]);
        break;

    case $request_uri === '/servicos' || $request_uri === '/servicos/index':
        $servicoController->index();
        break;
    case $request_uri === '/servicos/adicionar':
        $servicoController->adicionar();
        break;
    case $request_uri === '/servicos/store':
        $servicoController->store();
        break;
    case preg_match('/^\/servicos\/editar\/(\d+)$/', $request_uri, $matches):
        $servicoController->editar(['id' => $matches[1]]);
        break;
    case $request_uri === '/servicos/update':
        $servicoController->update();
        break;
    case preg_match('/^\/servicos\/deletar\/(\d+)$/', $request_uri, $matches):
        $servicoController->deletar(['id' => $matches[1]]);
        break;

    case $request_uri === '/pacotes' || $request_uri === '/pacotes/index':
        $pacoteController->index();
        break;
    case $request_uri === '/pacotes/adicionar':
        $pacoteController->adicionar();
        break;
    case $request_uri === '/pacotes/store':
        $pacoteController->store();
        break;
    case preg_match('/^\/pacotes\/editar\/(\d+)$/', $request_uri, $matches):
        $pacoteController->editar(['id' => $matches[1]]);
        break;
    case $request_uri === '/pacotes/update':
        $pacoteController->update();
        break;
    case preg_match('/^\/pacotes\/deletar\/(\d+)$/', $request_uri, $matches):
        $pacoteController->deletar(['id' => $matches[1]]);
        break;


    case $request_uri === '/agendamentos' || $request_uri === '/agendamentos/index':
        $agendamentoController->index();
        break;
    case $request_uri === '/agendamentos/adicionar':
        $agendamentoController->adicionar();
        break;
    case $request_uri === '/agendamentos/salvar':
        $agendamentoController->salvar();
        break;
    case preg_match('/^\/agendamentos\/editar$/', $request_uri): 
        $agendamentoController->editar();
        break;
    case $request_uri === '/agendamentos/atualizar': 
        $agendamentoController->atualizar();
        break;
    case preg_match('/^\/agendamentos\/deletar$/', $request_uri): 
        $agendamentoController->deletar();
        break;

    case $request_uri === '/atendimentos' || $request_uri === '/atendimentos/index':
        $atendimentoController->index();
        break;
    case $request_uri === '/atendimentos/adicionar':
        $atendimentoController->adicionar();
        break;
    case $request_uri === '/atendimentos/criar':
        $atendimentoController->criar();
        break;
    case preg_match('/^\/atendimentos\/editar\/(\d+)$/', $request_uri, $matches):
        $atendimentoController->editar(['id' => $matches[1]]);
        break;
    case $request_uri === '/atendimentos/update':
        $atendimentoController->update();
        break;
    case preg_match('/^\/atendimentos\/deletar\/(\d+)$/', $request_uri, $matches):
        $atendimentoController->deletar(['id' => $matches[1]]);
        break;

    case $request_uri === '/relatorios':
        $relatorioController->index();
        break;
    case $request_uri === '/relatorios/faturamento':
        $relatorioController->faturamentoPorPeriodo();
        break;
    case $request_uri === '/relatorios/profissionais':
        $relatorioController->atendimentosPorProfissional();
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Página Não Encontrada</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body><div class="container text-center py-5"><h1 class="display-1">404</h1><p class="lead">Oops! A página que você está procurando não foi encontrada.</p><a href="/meu_salao_app/" class="btn btn-primary">Voltar para o Início</a></div></body></html>';
        break;
}