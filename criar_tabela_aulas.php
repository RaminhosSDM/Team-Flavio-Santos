<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'conexao.php';

// Verificar se a tabela modulos existe
$result = $conn->query("SHOW TABLES LIKE 'modulos'");
if ($result->num_rows == 0) {
    // Criar tabela modulos se não existir
    $sql_criar_modulos = "CREATE TABLE IF NOT EXISTS modulos (
        id_modulo INT AUTO_INCREMENT PRIMARY KEY,
        nome_modulo VARCHAR(255) NOT NULL,
        descricao_modulo TEXT,
        nivel_modulo VARCHAR(50) NOT NULL,
        imagem_modulo VARCHAR(255),
        video_modulo VARCHAR(255),
        favorito TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql_criar_modulos)) {
        echo "Tabela 'modulos' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela modulos: " . $conn->error . "<br>";
    }
}

// Verificar se o módulo iniciante existe
$result = $conn->query("SELECT * FROM modulos WHERE id_modulo = 1");
if ($result->num_rows == 0) {
    // Inserir módulo iniciante
    $sql_inserir_modulo = "INSERT INTO modulos (id_modulo, nome_modulo, descricao_modulo, nivel_modulo, imagem_modulo) VALUES 
        (1, 'Módulo Iniciante', 'Aprenda os fundamentos básicos do Muay Thai', 'Iniciante', 'muay-thai-iniciante.jpg')";
    
    if ($conn->query($sql_inserir_modulo)) {
        echo "Módulo iniciante criado com sucesso!<br>";
    } else {
        echo "Erro ao criar módulo iniciante: " . $conn->error . "<br>";
    }
} else {
    echo "Módulo iniciante já existe.<br>";
}

// Verificar se a tabela aulas existe
$result = $conn->query("SHOW TABLES LIKE 'aulas'");
if ($result->num_rows == 0) {
    // Criar tabela aulas se não existir
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

    if ($conn->query($sql_criar_tabela)) {
        echo "Tabela 'aulas' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela aulas: " . $conn->error . "<br>";
    }
} else {
    echo "Tabela 'aulas' já existe.<br>";
}

// Verificar se já existem aulas para o módulo 1
$result = $conn->query("SELECT COUNT(*) as total FROM aulas WHERE id_modulo = 1");
$row = $result->fetch_assoc();

if ($row['total'] == 0) {
    // Inserir aulas de exemplo apenas se não existirem
    $sql_inserir_aulas = "INSERT INTO aulas (id_modulo, titulo_aula, descricao_aula, video_aula, duracao_aula, ordem_aula) VALUES 
        (1, 'Introdução ao Muay Thai', 'Aprenda os fundamentos básicos do Muay Thai', 'videos/aula1.mp4', 30, 1),
        (1, 'Posição Base e Movimentação', 'Aprenda a posição base e movimentação no ringue', 'videos/aula2.mp4', 30, 2),
        (1, 'Golpes Básicos', 'Aprenda os golpes básicos do Muay Thai', 'videos/aula3.mp4', 30, 3),
        (1, 'Defesa Básica', 'Aprenda as técnicas básicas de defesa', 'videos/aula4.mp4', 30, 4),
        (1, 'Combinações Iniciais', 'Aprenda as primeiras combinações de golpes', 'videos/aula5.mp4', 30, 5),
        (1, 'Treino de Resistência', 'Desenvolva sua resistência com exercícios específicos', 'videos/aula6.mp4', 30, 6)";

    if ($conn->query($sql_inserir_aulas)) {
        echo "Aulas de exemplo inseridas com sucesso!<br>";
    } else {
        echo "Erro ao inserir aulas: " . $conn->error . "<br>";
    }
} else {
    echo "Já existem aulas para o módulo 1.<br>";
}

// Listar todas as aulas do módulo 1
$result = $conn->query("SELECT * FROM aulas WHERE id_modulo = 1 ORDER BY ordem_aula");
echo "<br>Aulas cadastradas para o módulo 1:<br>";
while ($aula = $result->fetch_assoc()) {
    echo "- " . $aula['titulo_aula'] . " (Ordem: " . $aula['ordem_aula'] . ")<br>";
}

$modulos = [
    [
        'nome' => 'Módulo Intermediário',
        'descricao' => 'Aprofunde-se nas técnicas intermediárias do Muay Thai.',
        'nivel' => 'Intermediário',
        'imagem' => 'muay-thai-intermediario.jpg'
    ],
    [
        'nome' => 'Módulo Avançado',
        'descricao' => 'Domine técnicas avançadas e estratégias de luta.',
        'nivel' => 'Avançado',
        'imagem' => 'muay-thai-avancado.jpg'
    ],
    [
        'nome' => 'Competição',
        'descricao' => 'Preparação específica para atletas de competição.',
        'nivel' => 'Competição',
        'imagem' => 'muay-thai-competicao.jpg'
    ],
    [
        'nome' => 'Treino de Força',
        'descricao' => 'Foque no desenvolvimento de força e resistência.',
        'nivel' => 'Força',
        'imagem' => 'muay-thai-forca.jpg'
    ],
    [
        'nome' => 'Técnicas Avançadas',
        'descricao' => 'Aprimore técnicas especiais e golpes diferenciados.',
        'nivel' => 'Avançado',
        'imagem' => 'muay-thai-tecnicas.jpg'
    ]
];

foreach ($modulos as $modulo) {
    $stmt = $conn->prepare("INSERT INTO modulos (nome_modulo, descricao_modulo, nivel_modulo, imagem_modulo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $modulo['nome'], $modulo['descricao'], $modulo['nivel'], $modulo['imagem']);
    if ($stmt->execute()) {
        echo "Módulo '{$modulo['nome']}' inserido com sucesso!<br>";
    } else {
        echo "Erro ao inserir módulo '{$modulo['nome']}': " . $conn->error . "<br>";
    }
    $stmt->close();
}
?> 