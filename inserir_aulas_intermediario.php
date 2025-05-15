<?php
require 'conexao.php';

// Buscar o id do módulo intermediário
o = $conn->query("SELECT id_modulo FROM modulos WHERE nivel_modulo LIKE '%Intermedi%' LIMIT 1");
if (!$o || $o->num_rows === 0) {
    die('Módulo intermediário não encontrado.');
}
$id_modulo = $o->fetch_assoc()['id_modulo'];

// Inserir aulas de exemplo
$aulas = [
    [
        'Aula 1 - Técnicas de Soco',
        'Aprenda técnicas intermediárias de soco.',
        30,
        1,
        'videos/aula1.mp4'
    ],
    [
        'Aula 2 - Chutes Intermediários',
        'Aprimore seus chutes com novas variações.',
        35,
        2,
        'videos/aula2.mp4'
    ],
    [
        'Aula 3 - Defesas e Esquivas',
        'Defesas e esquivas para o nível intermediário.',
        28,
        3,
        'videos/aula3.mp4'
    ]
];

foreach ($aulas as $aula) {
    $stmt = $conn->prepare("INSERT INTO aulas (id_modulo, titulo_aula, descricao_aula, duracao_aula, ordem_aula, video_aula) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ississ", $id_modulo, $aula[0], $aula[1], $aula[2], $aula[3], $aula[4]);
    if ($stmt->execute()) {
        echo "Aula inserida: {$aula[0]}<br>";
    } else {
        echo "Erro ao inserir aula: {$aula[0]} - " . $stmt->error . "<br>";
    }
}

echo "<br>Inserção concluída."; 