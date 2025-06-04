<?php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Gestão de Salão'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/meu_salao_app/public/css/style.css">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div class="bg-dark text-white border-end border-secondary" id="sidebar-wrapper" style="min-height: 100vh; width: 250px;">
            <div class="sidebar-heading text-center py-4 fs-4 border-bottom border-secondary">
                <a href="/meu_salao_app/" class="text-white text-decoration-none">Meu Salão APP</a>
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary p-3" href="/meu_salao_app/">
                    <i class="fas fa-fw fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <a class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary p-3" href="/meu_salao_app/clientes/index">
                    <i class="fas fa-fw fa-users me-2"></i>Clientes
                </a>
                <a class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary p-3" href="/meu_salao_app/profissionais/index">
                    <i class="fas fa-fw fa-user-tie me-2"></i>Profissionais
                </a>
                <a class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary p-3" href="/meu_salao_app/servicos/index">
                    <i class="fas fa-fw fa-cut me-2"></i>Serviços
                </a>
                <a class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary p-3" href="/meu_salao_app/produtos/index">
                    <i class="fas fa-fw fa-boxes me-2"></i>Produtos
                </a>
                <a class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary p-3" href="/meu_salao_app/pacotes/index">
                    <i class="fas fa-fw fa-box-open me-2"></i>Pacotes
                </a>
                <a class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary p-3" href="/meu_salao_app/atendimentos/index">
                    <i class="fas fa-fw fa-calendar-alt me-2"></i>Atendimentos
                </a>
                <a class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary p-3" href="/meu_salao_app/relatorios/index">
                    <i class="fas fa-fw fa-chart-line me-2"></i>Relatórios
                </a>
            </div>
        </div>

        <div id="page-content-wrapper" class="flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Olá, Usuário!</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid py-4">
                <?php echo $content ?? ''; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcOdihloMw/pHJXXqMvXG" crossorigin="anonymous"></script>
    <script src="/meu_salao_app/public/js/script.js"></script>
    <script>
        var sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function () {
                document.getElementById('wrapper').classList.toggle('toggled');
            });
        }
    </script>
</body>
</html>