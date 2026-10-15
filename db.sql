CREATE DATABASE IF NOT EXISTS saep_farmacia;
USE saep_farmacia;

CREATE TABLE funcionario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    funcionario_id INT NOT NULL,
    medicamento VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL CHECK (quantidade > 0),
    categoria ENUM('genérico','referência','controlado','higiene') NOT NULL,
    urgencia ENUM('baixa','média','alta') NOT NULL DEFAULT 'baixa',
    data_solicitacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('solicitado','em separação','recebido') NOT NULL DEFAULT 'solicitado',
    FOREIGN KEY (funcionario_id) REFERENCES funcionario(id) ON DELETE CASCADE
);

INSERT INTO funcionario (nome, email) VALUES
('Ana Silva', 'ana@farmacia.com'),
('Bruno Costa', 'bruno@farmacia.com'),
('Carla Souza', 'carla@farmacia.com');

INSERT INTO pedido (funcionario_id, medicamento, quantidade, categoria, urgencia, status) VALUES
(1, 'Paracetamol', 50, 'genérico', 'alta', 'solicitado'),
(2, 'Dipirona', 30, 'referência', 'média', 'em separação'),
(3, 'Álcool 70%', 100, 'higiene', 'baixa', 'recebido'),
(1, 'Rivotril', 10, 'controlado', 'alta', 'solicitado'),
(2, 'Ibuprofeno', 20, 'genérico', 'baixa', 'em separação');
