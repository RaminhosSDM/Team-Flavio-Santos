<?php
require 'conexao.php';

// Verifica se o módulo já existe antes de inserir (pelo nome)
function modulo_existe($conn, $nome_modulo) {
    $sql = "SELECT 1 FROM modulos WHERE nome_modulo = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $nome_modulo);
    $stmt->execute();
    $stmt->store_result();
    $existe = $stmt->num_rows > 0;
    $stmt->close();
    return $existe;
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
    if (!modulo_existe($conn, $modulo['nome'])) {
        $sql = "INSERT INTO modulos (nome_modulo, descricao_modulo, nivel_modulo, imagem_modulo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $modulo['nome'], $modulo['descricao'], $modulo['nivel'], $modulo['imagem']);
        if ($stmt->execute()) {
            echo "Módulo '{$modulo['nome']}' inserido com sucesso!<br>";
        } else {
            echo "Erro ao inserir módulo '{$modulo['nome']}': " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "Módulo '{$modulo['nome']}' já existe.<br>";
    }
}

$conn->close();
?> 