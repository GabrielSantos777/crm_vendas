-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS crm_novo CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE crm_novo;

-- Criação da tabela vendas
DROP TABLE IF EXISTS vendas;

CREATE TABLE vendas (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    data DATE,
    data_hora DATETIME,
    forma_pagamento ENUM('cash', 'card'),
    valor DECIMAL(10,2),
    produto VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
