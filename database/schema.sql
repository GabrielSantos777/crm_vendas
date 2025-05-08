-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS crm_novo CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_general_ci;

USE crm_novo;

-- Criação da tabela vendas
DROP TABLE IF EXISTS vendas;

CREATE TABLE
    vendas (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        data DATE,
        cliente VARCHAR(225),
        data_hora DATETIME,
        forma_pagamento ENUM ('cash', 'card'),
        valor DECIMAL(10, 2),
        produto VARCHAR(100),
        quantidade INT NOT NULL,
        total DECIMAL(10,2) NOT NULL,
        stuatu VARCHAR(55)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- CRIAÇÃO DA TABELA DE RESERVAS
CREATE TABLE
    reservas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome_cliente VARCHAR(100) NOT NULL,
        data_reserva DATETIME NOT NULL,
        num_pessoas INT NOT NULL,
        observacoes TEXT
    );