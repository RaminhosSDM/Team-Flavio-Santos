<?php
require 'conexao.php';

// Buscar o id do módulo avançado
$result = $conn->query("SELECT id_modulo FROM modulos WHERE nome_modulo LIKE '%Avanc%' OR nome_modulo LIKE '%Avanç%' LIMIT 1");
if (!$result || $result->num_rows === 0) {
    die('Módulo avançado não encontrado.');
}
$id_modulo = $result->fetch_assoc()['id_modulo'];

// Inserir aulas de exemplo
$aulas = [
    [
        'Aula 1 - Técnicas Avançadas de Soco',
        'Aprimore suas técnicas de soco com combinações avançadas.',
        32,
        1,
        'videos/avancado1.mp4'
    ],
    [
        'Aula 2 - Chutes Avançados',
        'Chutes complexos e estratégias para lutas de alto nível.',
        36,
        2,
        'videos/avancado2.mp4'
    ],
    [
        'Aula 3 - Defesa e Contra-ataque',
        'Defesas e contra-ataques para situações avançadas.',
        30,
        3,
        'videos/avancado3.mp4'
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