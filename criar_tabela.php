<?php
require 'conexao.php';

$sql = "CREATE TABLE IF NOT EXISTS aulas (
    id_aula INT AUTO_INCREMENT PRIMARY KEY,
    id_modulo INT NOT NULL,
    titulo_aula VARCHAR(255) NOT NULL,
    descricao_aula TEXT,
    video_aula VARCHAR(255) NOT NULL,
    duracao_aula INT NOT NULL,
    ordem_aula INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabela 'aulas' criada com sucesso!";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}

$conn->close();
?> 