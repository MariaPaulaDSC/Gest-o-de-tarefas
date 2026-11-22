CREATE DATABASE IF NOT EXISTS taskmanager
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE taskmanager;

CREATE TABLE IF NOT EXISTS projetos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    descricao TEXT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tarefas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    projeto_id INT UNSIGNED NOT NULL,
    titulo VARCHAR(160) NOT NULL,
    descricao TEXT NULL,
    prazo DATE NULL,
    prioridade ENUM('baixa', 'media', 'alta') NOT NULL DEFAULT 'media',
    status ENUM('pendente', 'andamento', 'concluida') NOT NULL DEFAULT 'pendente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_tarefas_projetos
        FOREIGN KEY (projeto_id) REFERENCES projetos(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;
