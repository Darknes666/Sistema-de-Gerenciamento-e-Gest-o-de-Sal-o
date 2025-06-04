-- Criação do Banco de Dados
CREATE DATABASE `db_salao_gestao`;

-- Seleciona o banco de dados recém-criado
USE `db_salao_gestao`;

-- Tabela para Clientes
CREATE TABLE `clientes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `telefone` VARCHAR(20),
    `email` VARCHAR(255) UNIQUE,
    `imagem_perfil` VARCHAR(255) DEFAULT NULL, -- Campo para o caminho da imagem do cliente
    `data_cadastro` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela para Profissionais
CREATE TABLE `profissionais` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `especialidade` VARCHAR(100),
    `telefone` VARCHAR(20),
    `email` VARCHAR(255) UNIQUE,
    `comissao_percentual` DECIMAL(5,2) DEFAULT 0.00
);

-- Tabela para Produtos
CREATE TABLE `produtos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `descricao` TEXT,
    `preco_compra` DECIMAL(10,2) DEFAULT 0.00,
    `preco_venda` DECIMAL(10,2) DEFAULT 0.00,
    `estoque` INT DEFAULT 0,
    `imagem_produto` VARCHAR(255) DEFAULT NULL -- Campo para o caminho da imagem do produto
);

-- Tabela para Serviços
CREATE TABLE `servicos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `descricao` TEXT,
    `preco` DECIMAL(10,2) NOT NULL,
    `duracao_minutos` INT DEFAULT 30
);

-- Tabela para Pacotes de Serviços
CREATE TABLE `pacotes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `descricao` TEXT,
    `preco_total` DECIMAL(10,2) NOT NULL,
    `data_criacao` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela auxiliar para ligar serviços a pacotes (muitos-para-muitos)
CREATE TABLE `pacote_servicos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `pacote_id` INT NOT NULL,
    `servico_id` INT NOT NULL,
    FOREIGN KEY (`pacote_id`) REFERENCES `pacotes`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`servico_id`) REFERENCES `servicos`(`id`) ON DELETE CASCADE,
    UNIQUE (`pacote_id`, `servico_id`) -- Garante que um serviço não seja adicionado duas vezes ao mesmo pacote
);

-- Tabela para Registros de Atendimentos (agendamentos e serviços realizados)
CREATE TABLE `atendimentos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `cliente_id` INT NOT NULL,
    `profissional_id` INT NOT NULL,
    `servico_id` INT, -- Pode ser um serviço individual...
    `pacote_id` INT,  -- ...ou um pacote
    `data_hora` DATETIME NOT NULL,
    `valor_pago` DECIMAL(10,2) NOT NULL,
    `status` VARCHAR(50) DEFAULT 'Agendado', -- Ex: Agendado, Concluído, Cancelado
    FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`profissional_id`) REFERENCES `profissionais`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`servico_id`) REFERENCES `servicos`(`id`) ON DELETE SET NULL, -- Se o serviço for deletado, não afeta o histórico de atendimento
    FOREIGN KEY (`pacote_id`) REFERENCES `pacotes`(`id`) ON DELETE SET NULL
);


CREATE TABLE `vendas_produtos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `cliente_id` INT, 
    `produto_id` INT NOT NULL,
    `quantidade` INT NOT NULL,
    `preco_unitario_venda` DECIMAL(10,2) NOT NULL,
    `data_venda` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`produto_id`) REFERENCES `produtos`(`id`) ON DELETE CASCADE
);