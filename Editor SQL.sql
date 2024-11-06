-- Criação do banco de dados
CREATE DATABASE site;
USE site;

-- Criação da tabela de usuários
CREATE TABLE tbl_usuario (
    usu_codigo INT PRIMARY KEY AUTO_INCREMENT,
    usu_nome VARCHAR(100),    -- Aumentei o tamanho do nome para 100 caracteres
    usu_email VARCHAR(100)    -- Aumentei o tamanho do email para 100 caracteres
);

-- Criação da tabela de tarefas
CREATE TABLE tbl_tarefa (
    tar_codigo INT PRIMARY KEY AUTO_INCREMENT,
    tar_setor VARCHAR(50),    -- Aumentei o tamanho do setor para 50 caracteres
    tar_prioridade VARCHAR(40),
    tar_descricao VARCHAR(255), -- Aumentei o tamanho da descrição para 255 caracteres
    tar_status VARCHAR(60),
    usu_codigo INT,           -- Defini a coluna de chave estrangeira na criação
    CONSTRAINT fk_usu_codigo FOREIGN KEY (usu_codigo) REFERENCES tbl_usuario(usu_codigo)
);

-- Verificar as tabelas e as relações
SELECT * FROM tbl_tarefa;
