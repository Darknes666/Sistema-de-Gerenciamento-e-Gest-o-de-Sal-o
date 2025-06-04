<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../app/Controllers/ClienteController.php';
require_once __DIR__ . '/../app/Controllers/ProfissionalController.php';
require_once __DIR__ . '/../app/Controllers/ProdutoController.php';
require_once __DIR__ . '/../app/Controllers/ServicoController.php';
require_once __DIR__ . '/../app/Controllers/PacoteController.php';


$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/meu_salao_app';
$request_uri = str_replace($base_path, '', $request_uri);
$request_uri = strtok($request_uri, '?');
$request_uri = rtrim($request_uri, '/');


switch ($request_uri) {
    case '':
    case '/':
        echo "<!DOCTYPE html><html lang='pt-BR'><head><meta charset='UTF-8'><title>Dashboard</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css'><link rel='stylesheet' href='/meu_salao_app/public/css/style.css'></head><body>";
        echo "<div class='d-flex' id='wrapper'>";
        include __DIR__ . '/../app/Views/layout/main.php'; // Inclua o layout para ter o sidebar
        echo "<div id='page-content-wrapper' class='flex-grow-1'>";
        echo "<nav class='navbar navbar-expand-lg navbar-light bg-light border-bottom'><div class='container-fluid'><button class='btn btn-primary' id='sidebarToggle'><i class='fas fa-bars'></i></button><div class='collapse navbar-collapse'><ul class='navbar-nav ms-auto mt-2 mt-lg-0'><li class='nav-item active'><a class='nav-link' href='#'>Olá, Usuário!</a></li></ul></div></div></nav>";
        echo "<div class='container-fluid py-4'>";
        echo "<h1>Bem-vindo ao Meu Salão APP!</h1>";
        echo "<p>Use o menu lateral para navegar e gerenciar seu salão.</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>";
        echo "<script src='/meu_salao_app/public/js/script.js'></script>";
        echo "</body></html>";
        break;

    case '/clientes':
    case '/clientes/index':
        $controller = new ClienteController();
        $controller->index();
        break;
    case '/clientes/adicionar':
        $controller = new ClienteController();
        $controller->adicionar();
        break;
    case '/clientes/store':
        $controller = new ClienteController();
        $controller->store();
        break;
    case '/clientes/editar':
        $controller = new ClienteController();
        $controller->editar();
        break;
    case '/clientes/update':
        $controller = new ClienteController();
        $controller->update();
        break;
    case '/clientes/deletar':
        $controller = new ClienteController();
        $controller->deletar();
        break;

    case '/profissionais':
    case '/profissionais/index':
        $controller = new ProfissionalController();
        $controller->index();
        break;
    case '/profissionais/adicionar':
        $controller = new ProfissionalController();
        $controller->adicionar();
        break;
    case '/profissionais/store':
        $controller = new ProfissionalController();
        $controller->store();
        break;
    case '/profissionais/editar':
        $controller = new ProfissionalController();
        $controller->editar();
        break;
    case '/profissionais/update':
        $controller = new ProfissionalController();
        $controller->update();
        break;
    case '/profissionais/deletar':
        $controller = new ProfissionalController();
        $controller->deletar();
        break;

    case '/produtos':
    case '/produtos/index':
        $controller = new ProdutoController();
        $controller->index();
        break;
    case '/produtos/adicionar':
        $controller = new ProdutoController();
        $controller->adicionar();
        break;
    case '/produtos/store':
        $controller = new ProdutoController();
        $controller->store();
        break;
    case '/produtos/editar':
        $controller = new ProdutoController();
        $controller->editar();
        break;
    case '/produtos/update':
        $controller = new ProdutoController();
        $controller->update();
        break;
    case '/produtos/deletar':
        $controller = new ProdutoController();
        $controller->deletar();
        break;

    case '/servicos':
    case '/servicos/index':
        $controller = new ServicoController();
        $controller->index();
        break;
    case '/servicos/adicionar':
        $controller = new ServicoController();
        $controller->adicionar();
        break;
    case '/servicos/store':
        $controller = new ServicoController();
        $controller->store();
        break;
    case '/servicos/editar':
        $controller = new ServicoController();
        $controller->editar();
        break;
    case '/servicos/update':
        $controller = new ServicoController();
        $controller->update();
        break;
    case '/servicos/deletar':
        $controller = new ServicoController();
        $controller->deletar();
        break;

    case '/pacotes':
    case '/pacotes/index':
        $controller = new PacoteController();
        $controller->index();
        break;
    case '/pacotes/adicionar':
        $controller = new PacoteController();
        $controller->adicionar();
        break;
    case '/pacotes/store':
        $controller = new PacoteController();
        $controller->store();
        break;
    case '/pacotes/editar':
        $controller = new PacoteController();
        $controller->editar();
        break;
    case '/pacotes/update':
        $controller = new PacoteController();
        $controller->update();
        break;
    case '/pacotes/deletar':
        $controller = new PacoteController();
        $controller->deletar();
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Página Não Encontrada</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body><div class="container text-center py-5"><h1 class="display-1">404</h1><p class="lead">Oops! A página que você está procurando não foi encontrada.</p><a href="/meu_salao_app/" class="btn btn-primary">Voltar para o Início</a></div></body></html>';
        break;
}
?>