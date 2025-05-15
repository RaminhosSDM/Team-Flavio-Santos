<?php
session_start();
require 'conexao.php';

// Verifica se está logado e é admin
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

// Verifica se o ID do utilizador foi passado
if (isset($_GET['id'])) {
    $id_user = intval($_GET['id']);

    // Verifica se o ID do utilizador existe
    $stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Exclui o utilizador da base de dados
        $stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();

        // Redireciona para a página de administração com sucesso
        header("Location: dashboard.php?status=success");
        exit();
    } else {
        echo "Utilizador não encontrado!";
    }
} else {
    echo "ID de utilizador não fornecido!";
}
?>
