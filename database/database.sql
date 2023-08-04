CREATE DATABASE tarefas;
use DATABASE tarefas;
CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE,
    custo DECIMAL(10, 2) CHECK (custo >= 0),
    data_limite DATE,
    ordem_apresentacao INT NOT NULL
);
