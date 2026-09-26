CREATE DATABASE IF NOT EXISTS CRUD_FARMACIA
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

use CRUD_FARMACIA;

CREATE TABLE funcionario (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cargo VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE filial (
    id_filial INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(150) NOT NULL,
    bairro VARCHAR(80),
    telefone VARCHAR(20)
);

CREATE TABLE status_pedido (
    id_status INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL UNIQUE,
    cor VARCHAR(20)
);

CREATE TABLE medicamento (
    id_medicamento INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    principio_ativo VARCHAR(120),
    apresentacao VARCHAR(100),
    unidade_medida VARCHAR(30),
    estoque_minimo INT DEFAULT 0
);

CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    observacao TEXT,

    id_funcionario INT NOT NULL,
    id_filial INT NOT NULL,
    id_status INT NOT NULL,

    CONSTRAINT fk_pedido_funcionario
        FOREIGN KEY (id_funcionario)
        REFERENCES funcionario(id_funcionario),

    CONSTRAINT fk_pedido_filial
        FOREIGN KEY (id_filial)
        REFERENCES filial(id_filial),

    CONSTRAINT fk_pedido_status
        FOREIGN KEY (id_status)
        REFERENCES status_pedido(id_status)
);



CREATE TABLE item_pedido (
    id_item INT AUTO_INCREMENT PRIMARY KEY,

    id_pedido INT NOT NULL,
    id_medicamento INT NOT NULL,

    quantidade_solicitada INT NOT NULL,
    quantidade_atendida INT DEFAULT 0,
    data_prevista DATE,

    CONSTRAINT fk_item_pedido
        FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido)
        ON DELETE CASCADE,

    CONSTRAINT fk_item_medicamento
        FOREIGN KEY (id_medicamento)
        REFERENCES medicamento(id_medicamento),

    CONSTRAINT chk_quantidade_solicitada
        CHECK (quantidade_solicitada > 0),

    CONSTRAINT chk_quantidade_atendida
        CHECK (quantidade_atendida >= 0)
);


CREATE TABLE historico_status (
    id_historico INT AUTO_INCREMENT PRIMARY KEY,

    id_pedido INT NOT NULL,
    id_status INT NOT NULL,
    id_funcionario INT NOT NULL,

    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    observacao TEXT,

    CONSTRAINT fk_historico_pedido
        FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido)
        ON DELETE CASCADE,

    CONSTRAINT fk_historico_status
        FOREIGN KEY (id_status)
        REFERENCES status_pedido(id_status),

    CONSTRAINT fk_historico_funcionario
        FOREIGN KEY (id_funcionario)
        REFERENCES funcionario(id_funcionario)
);

INSERT INTO status_pedido (descricao, cor) VALUES
('Aguardando', '#FFC107'),
('Em separação', '#17A2B8'),
('Em transporte', '#007BFF'),
('Recebido', '#28A745'),
('Cancelado', '#DC3545');