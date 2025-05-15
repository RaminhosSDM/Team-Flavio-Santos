<?php
require 'verificar_login.php';
require 'conexao.php';

header('Content-Type: application/json');

if (isset($_GET['id_modulo'])) {
    $id_modulo = intval($_GET['id_modulo']);
    
    $sql = "SELECT video_path FROM modulos WHERE id_modulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_modulo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'success' => true,
            'video_path' => $row['video_path']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Vídeo não encontrado'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'ID do módulo não fornecido'
    ]);
}

$stmt->close();
?> 