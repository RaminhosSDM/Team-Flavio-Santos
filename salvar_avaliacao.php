<?php
require 'verificar_login.php';
require 'conexao.php';

// Debug da sessão
error_log("Conteúdo da sessão: " . print_r($_SESSION, true));

// Verifica se o usuário está logado
if (!isset($_SESSION['id_user'])) {
    error_log("Usuário não está logado");
    $_SESSION['erro'] = "Por favor, faça login para enviar uma avaliação.";
    header("Location: index.php");
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $id_usuario = $_SESSION['id_user'];
    $comentario = trim($_POST['comentario']);

    // Debug
    error_log("ID do usuário: " . $id_usuario);
    error_log("Comentário: " . $comentario);

    // Busca os dados do usuário
    $sql_usuario = "SELECT username, imagem_user FROM users WHERE id_user = " . intval($id_usuario);
    $result_usuario = $conn->query($sql_usuario);
    
    if ($result_usuario && $result_usuario->num_rows > 0) {
        $row_usuario = $result_usuario->fetch_assoc();
        $nome = $row_usuario['username'];
        $foto_perfil = $row_usuario['imagem_user'];

        // Debug dos dados obtidos
        error_log("Nome do usuário: " . $nome);
        error_log("Foto do perfil: " . $foto_perfil);

        // Validação básica
        if (empty($comentario)) {
            $_SESSION['erro'] = "Por favor, preencha o comentário.";
            header("Location: index.php");
            exit();
        }

        // Verifica se a tabela avaliacoes existe
        $check_table = $conn->query("SHOW TABLES LIKE 'avaliacoes'");
        if ($check_table->num_rows == 0) {
            // Cria a tabela se não existir
            $create_table = "CREATE TABLE avaliacoes (
                id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                comentario TEXT NOT NULL,
                data_avaliacao DATETIME NOT NULL,
                foto_perfil VARCHAR(255)
            )";
            
            if (!$conn->query($create_table)) {
                error_log("Erro ao criar tabela avaliacoes: " . $conn->error);
                $_SESSION['erro'] = "Erro ao configurar o sistema. Por favor, contate o administrador.";
                header("Location: index.php");
                exit();
            }
        }

        // Escapa os valores para evitar SQL injection
        $nome = $conn->real_escape_string($nome);
        $comentario = $conn->real_escape_string($comentario);
        $foto_perfil = $conn->real_escape_string($foto_perfil);

        // Tenta inserir a avaliação
        $sql = "INSERT INTO avaliacoes (nome, comentario, data_avaliacao, foto_perfil) 
                VALUES ('$nome', '$comentario', NOW(), '$foto_perfil')";
        
        error_log("Query SQL: " . $sql);

        if ($conn->query($sql)) {
            $_SESSION['sucesso'] = "Avaliação enviada com sucesso!";
        } else {
            error_log("Erro MySQL: " . $conn->error);
            $_SESSION['erro'] = "Erro ao enviar avaliação. Por favor, tente novamente.";
        }
    } else {
        error_log("Usuário não encontrado: " . $id_usuario);
        $_SESSION['erro'] = "Usuário não encontrado. Por favor, faça login novamente.";
    }

    header("Location: index.php");
    exit();
} else {
    // Se alguém tentar acessar diretamente este arquivo
    header("Location: index.php");
    exit();
}
?> 