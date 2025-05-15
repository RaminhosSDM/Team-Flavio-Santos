<?php
require 'verificar_login.php';
require 'conexao.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_modulo = isset($_POST['id_modulo']) ? intval($_POST['id_modulo']) : 0;
    $favorito = isset($_POST['favorito']) ? intval($_POST['favorito']) : 0;
    
    if ($id_modulo > 0) {
        $sql = "UPDATE modulos SET favorito = ? WHERE id_modulo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $favorito, $id_modulo);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao atualizar favorito']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID do módulo inválido']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método não permitido']);
}

$conn->close(); 