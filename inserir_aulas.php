<?php
require 'conexao.php';

if (!isset($_GET['id'])) {
    die("Erro: ID do módulo não fornecido na URL");
}
$id_modulo = intval($_GET['id']);

// Verificar se a tabela aulas existe
$result = $conn->query("SHOW TABLES LIKE 'aulas'");
if ($result->num_rows == 0) {
    // Criar a tabela se não existir
    $sql_criar_tabela = "CREATE TABLE IF NOT EXISTS aulas (
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
    
    if ($conn->query($sql_criar_tabela) === TRUE) {
        echo "Tabela 'aulas' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela: " . $conn->error . "<br>";
        exit;
    }
}

// Inserir aulas para o módulo 1 (Iniciante)
$sql_aulas_iniciante = "INSERT INTO aulas (id_modulo, titulo_aula, descricao_aula, video_aula, duracao_aula, ordem_aula) VALUES
(1, 'Introdução ao Muay Thai', 'Aprenda os fundamentos básicos e a história do Muay Thai', 'videos/aula1.mp4', 30, 1),
(1, 'Posição Básica', 'Aprenda a posição correta para iniciantes e movimentação básica', 'videos/aula2.mp4', 25, 2),
(1, 'Golpes Básicos - Socos', 'Aprenda os socos fundamentais do Muay Thai', 'videos/aula3.mp4', 35, 3),
(1, 'Golpes Básicos - Chutes', 'Aprenda os chutes básicos e suas aplicações', 'videos/aula4.mp4', 30, 4),
(1, 'Defesa Básica', 'Técnicas fundamentais de defesa e esquiva', 'videos/aula5.mp4', 30, 5)";

// Inserir aulas para o módulo 2 (Intermediário)
$sql_aulas_intermediario = "INSERT INTO aulas (id_modulo, titulo_aula, descricao_aula, video_aula, duracao_aula, ordem_aula) VALUES
(2, 'Combinações Intermediárias', 'Aprenda combinações de golpes mais complexas', 'videos/aula6.mp4', 40, 1),
(2, 'Técnicas de Clinch', 'Aprenda as técnicas básicas de clinch no Muay Thai', 'videos/aula7.mp4', 35, 2),
(2, 'Defesa Avançada', 'Técnicas mais avançadas de defesa e contra-ataque', 'videos/aula8.mp4', 40, 3),
(2, 'Trabalho de Joelhos', 'Aprenda técnicas de joelho no clinch', 'videos/aula9.mp4', 35, 4),
(2, 'Trabalho de Cotovelos', 'Técnicas básicas de cotovelo no Muay Thai', 'videos/aula10.mp4', 30, 5)";

// Inserir aulas para o módulo 3 (Avançado)
$sql_aulas_avancado = "INSERT INTO aulas (id_modulo, titulo_aula, descricao_aula, video_aula, duracao_aula, ordem_aula) VALUES
(3, 'Combinações Avançadas', 'Combinações complexas de golpes para lutadores avançados', 'videos/aula11.mp4', 45, 1),
(3, 'Clinch Avançado', 'Técnicas avançadas de clinch e derrubadas', 'videos/aula12.mp4', 40, 2),
(3, 'Estratégias de Luta', 'Aprenda estratégias e táticas para competição', 'videos/aula13.mp4', 45, 3),
(3, 'Técnicas Especiais', 'Técnicas especiais e golpes raros do Muay Thai', 'videos/aula14.mp4', 40, 4),
(3, 'Preparação para Competição', 'Treinamento específico para competidores', 'videos/aula15.mp4', 50, 5)";

// Executar as inserções
if ($conn->query($sql_aulas_iniciante) === TRUE) {
    echo "Aulas do módulo Iniciante inseridas com sucesso!<br>";
} else {
    echo "Erro ao inserir aulas do módulo Iniciante: " . $conn->error . "<br>";
}

if ($conn->query($sql_aulas_intermediario) === TRUE) {
    echo "Aulas do módulo Intermediário inseridas com sucesso!<br>";
} else {
    echo "Erro ao inserir aulas do módulo Intermediário: " . $conn->error . "<br>";
}

if ($conn->query($sql_aulas_avancado) === TRUE) {
    echo "Aulas do módulo Avançado inseridas com sucesso!<br>";
} else {
    echo "Erro ao inserir aulas do módulo Avançado: " . $conn->error . "<br>";
}

$conn->close();
?> 