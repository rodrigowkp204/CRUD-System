-- Criação do banco de dados
CREATE DATABASE users_db;

-- Seleciona o banco de dados criado
USE users_db;

-- Criação da tabela `users`
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nascimento VARCHAR(10) NOT NULL,
    imagem VARCHAR(255) DEFAULT NULL,
    idade INT(11) DEFAULT NULL,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);
