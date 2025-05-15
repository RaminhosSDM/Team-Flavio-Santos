<?php
session_start();
require 'conexao.php';

// Verifica se está logado e é admin
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

// Verifica se o ID do módulo foi passado
if (isset($_GET['id'])) {
    $id_modulo = intval($_GET['id']);

    // Verifica se o ID do módulo existe
    $stmt = $conn->prepare("SELECT * FROM modulos WHERE id_modulo = ?");
    $stmt->bind_param("i", $id_modulo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Exclui o módulo da base de dados
        $stmt = $conn->prepare("DELETE FROM modulos WHERE id_modulo = ?");
        $stmt->bind_param("i", $id_modulo);
        $stmt->execute();

        // Redireciona para a página de administração com sucesso
        header("Location: dashboard.php?status=success");
        exit();
    } else {
        echo "Módulo não encontrado!";
    }
} else {
    echo "ID de módulo não fornecido!";
}
?>
