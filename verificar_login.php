<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_user'])) {
    // Redireciona para a página de login
    header('Location: login.php');
    exit;
}
?> 