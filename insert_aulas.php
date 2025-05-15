<?php
require 'conexao.php';

// Array com as aulas a serem inseridas
$aulas = [
    [
        'id_modulo' => 1,
        'titulo_aula' => 'Introdução ao Muay Thai',
        'descricao_aula' => 'Aprenda os fundamentos básicos e a história do Muay Thai',
        'video_aula' => 'videos/aula1.mp4',
        'duracao_aula' => 30,
        'ordem_aula' => 1
    ],
    [
        'id_modulo' => 1,
        'titulo_aula' => 'Posição Básica',
        'descricao_aula' => 'Aprenda a posição correta para iniciantes e movimentação básica',
        'video_aula' => 'videos/aula2.mp4',
        'duracao_aula' => 25,
        'ordem_aula' => 2
    ],
    [
        'id_modulo' => 1,
        'titulo_aula' => 'Golpes Básicos - Socos',
        'descricao_aula' => 'Aprenda os socos fundamentais do Muay Thai',
        'video_aula' => 'videos/aula3.mp4',
        'duracao_aula' => 35,
        'ordem_aula' => 3
    ],
    [
        'id_modulo' => 1,
        'titulo_aula' => 'Golpes Básicos - Chutes',
        'descricao_aula' => 'Aprenda os chutes básicos e suas aplicações',
        'video_aula' => 'videos/aula4.mp4',
        'duracao_aula' => 30,
        'ordem_aula' => 4
    ],
    [
        'id_modulo' => 1,
        'titulo_aula' => 'Defesa Básica',
        'descricao_aula' => 'Técnicas fundamentais de defesa e esquiva',
        'video_aula' => 'videos/aula5.mp4',
        'duracao_aula' => 30,
        'ordem_aula' => 5
    ]
];

// Preparar a query
$stmt = $conn->prepare("INSERT INTO aulas (id_modulo, titulo_aula, descricao_aula, video_aula, duracao_aula, ordem_aula) VALUES (?, ?, ?, ?, ?, ?)");

// Inserir cada aula
$sucessos = 0;
$erros = 0;

foreach ($aulas as $aula) {
    try {
        $stmt->bind_param("isssii", 
            $aula['id_modulo'],
            $aula['titulo_aula'],
            $aula['descricao_aula'],
            $aula['video_aula'],
            $aula['duracao_aula'],
            $aula['ordem_aula']
        );
        
        if ($stmt->execute()) {
            $sucessos++;
        } else {
            $erros++;
            echo "Erro ao inserir aula: " . $aula['titulo_aula'] . " - " . $stmt->error . "<br>";
        }
    } catch (Exception $e) {
        $erros++;
        echo "Erro ao inserir aula: " . $aula['titulo_aula'] . " - " . $e->getMessage() . "<br>";
    }
}

echo "Processo concluído!<br>";
echo "Aulas inseridas com sucesso: " . $sucessos . "<br>";
echo "Erros: " . $erros . "<br>";

$stmt->close();
$conn->close();
?> 