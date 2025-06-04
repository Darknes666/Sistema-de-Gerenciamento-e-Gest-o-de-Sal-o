<?php

require_once __DIR__ . '/../Models/Produto.php';

class ProdutoController {
    private $produto;

    public function __construct() {
        $this->produto = new Produto();
    }

    private function loadView($viewPath, $data = []) {
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/' . $viewPath . '.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout/main.php';
    }

    public function index() {
        $stmt = $this->produto->ler();
        $num = $stmt->num_rows;

        $this->loadView('produtos/index', [
            'pageTitle' => 'Gerenciar Produtos',
            'stmt' => $stmt,
            'num' => $num
        ]);
    }

    public function adicionar() {
        $this->loadView('produtos/adicionar', [
            'pageTitle' => 'Adicionar Novo Produto'
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagem_produto_path = null;
            if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../../public/images/produtos/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['imagem_produto']['name'], PATHINFO_EXTENSION);
                $new_file_name = uniqid('produto_') . '.' . $file_extension;
                $upload_file_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($_FILES['imagem_produto']['tmp_name'], $upload_file_path)) {
                    $imagem_produto_path = 'public/images/produtos/' . $new_file_name;
                } else {
                    $_SESSION['message'] = "Erro ao fazer upload da imagem do produto.";
                }
            }

            $this->produto->nome = $_POST['nome'] ?? '';
            $this->produto->descricao = $_POST['descricao'] ?? '';
            $this->produto->preco_compra = $_POST['preco_compra'] ?? 0.00;
            $this->produto->preco_venda = $_POST['preco_venda'] ?? 0.00;
            $this->produto->estoque = $_POST['estoque'] ?? 0;
            $this->produto->imagem_produto = $imagem_produto_path;

            if ($this->produto->criar()) {
                $_SESSION['message'] = "Produto criado com sucesso!";
                header("Location: /meu_salao_app/produtos/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao criar produto.";
                header("Location: /meu_salao_app/produtos/adicionar");
                exit();
            }
        }
        header("Location: /meu_salao_app/produtos/adicionar");
        exit();
    }

    public function editar() {
        $this->produto->id = $_GET['id'] ?? null;

        if (!$this->produto->id || !$this->produto->lerUm()) {
            $_SESSION['message'] = "Produto não encontrado.";
            header("Location: /meu_salao_app/produtos/index");
            exit();
        }

        $this->loadView('produtos/editar', [
            'pageTitle' => 'Editar Produto',
            'produto' => $this->produto
        ]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->produto->id = $_POST['id'] ?? null;
            if (!$this->produto->id) {
                $_SESSION['message'] = "ID do produto não especificado para atualização.";
                header("Location: /meu_salao_app/produtos/index");
                exit();
            }

            $this->produto->lerUm();
            $imagem_produto_path = $this->produto->imagem_produto;

            if (isset($_FILES['imagem_produto']) && $_FILES['imagem_produto']['error'] == UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../../public/images/produtos/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['imagem_produto']['name'], PATHINFO_EXTENSION);
                $new_file_name = uniqid('produto_') . '.' . $file_extension;
                $upload_file_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($_FILES['imagem_produto']['tmp_name'], $upload_file_path)) {
                    if ($this->produto->imagem_produto && file_exists(__DIR__ . '/../../' . $this->produto->imagem_produto)) {
                        unlink(__DIR__ . '/../../' . $this->produto->imagem_produto);
                    }
                    $imagem_produto_path = 'public/images/produtos/' . $new_file_name;
                } else {
                    $_SESSION['message'] = "Erro ao mover o novo arquivo de imagem do produto.";
                }
            }

            $this->produto->nome = $_POST['nome'] ?? '';
            $this->produto->descricao = $_POST['descricao'] ?? '';
            $this->produto->preco_compra = $_POST['preco_compra'] ?? 0.00;
            $this->produto->preco_venda = $_POST['preco_venda'] ?? 0.00;
            $this->produto->estoque = $_POST['estoque'] ?? 0;
            $this->produto->imagem_produto = $imagem_produto_path;

            if ($this->produto->atualizar()) {
                $_SESSION['message'] = "Produto atualizado com sucesso!";
                header("Location: /meu_salao_app/produtos/index");
                exit();
            } else {
                $_SESSION['message'] = "Erro ao atualizar produto.";
                header("Location: /meu_salao_app/produtos/editar?id=" . $this->produto->id);
                exit();
            }
        }
        header("Location: /meu_salao_app/produtos/index");
        exit();
    }

    public function deletar() {
        $this->produto->id = $_GET['id'] ?? null;

        if (!$this->produto->id) {
            $_SESSION['message'] = "ID do produto não especificado para exclusão.";
            header("Location: /meu_salao_app/produtos/index");
            exit();
        }

        if ($this->produto->deletar()) {
            $_SESSION['message'] = "Produto deletado com sucesso!";
            header("Location: /meu_salao_app/produtos/index");
            exit();
        } else {
            $_SESSION['message'] = "Erro ao deletar produto.";
            header("Location: /meu_salao_app/produtos/index");
            exit();
        }
    }
}
?>