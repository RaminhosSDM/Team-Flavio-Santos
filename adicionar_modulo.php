<?php

require 'verificar_login.php';
require 'conexao.php';

// Verifica se o usuário está logado e é administrador (id_user = 1)
if (!isset($_SESSION['id_user']) || $_SESSION['id_user'] != 1) {
    header("Location: index.php");
    exit();
}

include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $nivel = $_POST['nivel'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0 && isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $targetDir = "src/imgs/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        $safeImageName = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', basename($_FILES['imagem']['name']));
        $targetFile = $targetDir . $safeImageName;

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedImageTypes = ['jpg', 'png', 'jpeg', 'gif'];

        $videoDir = "src/videos/";
        if (!is_dir($videoDir)) {
            mkdir($videoDir, 0755, true);
        }

        $safeVideoName = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', basename($_FILES['video']['name']));
        $videoFile = $videoDir . $safeVideoName;
        $videoFileType = strtolower(pathinfo($videoFile, PATHINFO_EXTENSION));
        $allowedVideoTypes = ['mp4', 'mov', 'avi'];

        if (in_array($imageFileType, $allowedImageTypes) && in_array($videoFileType, $allowedVideoTypes)) {
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $targetFile) && move_uploaded_file($_FILES['video']['tmp_name'], $videoFile)) {
                $stmt = $conn->prepare("INSERT INTO modulos (nome_modulo, descricao_modulo, imagem_modulo, video_modulo, nivel_modulo, favorito) VALUES (?, ?, ?, ?, ?, 0)");
                $stmt->bind_param("sssss", $nome, $descricao, $safeImageName, $videoFile, $nivel);

                if ($stmt->execute()) {
                    $_SESSION['mensagem'] = "Módulo adicionado com sucesso!";
                    $_SESSION['tipo_mensagem'] = "success";
                    header("Location: adicionar_modulo.php");
                    exit();
                } else {
                    $_SESSION['mensagem'] = "Erro ao salvar o módulo: " . $stmt->error;
                    $_SESSION['tipo_mensagem'] = "danger";
                }
                $stmt->close();
            } else {
                $_SESSION['mensagem'] = "Erro ao mover os arquivos para o diretório.";
                $_SESSION['tipo_mensagem'] = "danger";
            }
        } else {
            $_SESSION['mensagem'] = "Somente arquivos de imagem (JPG, JPEG, PNG, GIF) e vídeo (MP4, MOV, AVI) são permitidos.";
            $_SESSION['tipo_mensagem'] = "danger";
        }
    } else {
        $_SESSION['mensagem'] = "Erro no upload dos arquivos.";
        $_SESSION['tipo_mensagem'] = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adicionar Módulo - Team Flávio Santos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="src/styles.css">
    <style>
        body {
            background: #f8f9fa;
            padding-top: 80px;
        }

        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 2.5rem;
            animation: fadeIn 1s ease;
            margin-top: 2rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .form-card h2 {
            color: #2d2d2d;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            padding-bottom: 1rem;
        }

        .form-card h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, #dc3545, #c82333);
            border-radius: 2px;
        }

        .form-label {
            font-weight: 600;
            color: #2d2d2d;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .btn-submit {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            background: linear-gradient(135deg, #c82333, #bd2130);
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }

        .file-input-trigger {
            display: block;
            padding: 0.8rem 1rem;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            text-align: center;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .file-input-wrapper:hover .file-input-trigger {
            border-color: #dc3545;
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 1.5rem;
            }
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .alert i {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if (isset($_SESSION['mensagem'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['tipo_mensagem']; ?> alert-dismissible fade show" role="alert">
                        <i class="fas <?php echo $_SESSION['tipo_mensagem'] == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                        <?php 
                        echo $_SESSION['mensagem'];
                        unset($_SESSION['mensagem']);
                        unset($_SESSION['tipo_mensagem']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                <?php endif; ?>

                <div class="form-card">
                    <h2>Adicionar Novo Módulo</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="nome" class="form-label">Nome do Módulo</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Insere o nome do módulo..." required>
                            <small class="form-text">Pode usar espaços e caracteres especiais no nome do módulo</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" placeholder="Escreve uma descrição detalhada do módulo..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="nivel" class="form-label">Nível do Módulo</label>
                            <select class="form-select" id="nivel" name="nivel" required>
                                <option value="">Selecione o nível...</option>
                                <option value="Iniciante">Iniciante</option>
                                <option value="Intermediário">Intermediário</option>
                                <option value="Avançado">Avançado</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Imagem do Módulo</label>
                            <div class="file-input-wrapper">
                                <div class="file-input-trigger">
                                    <i class="fas fa-image me-2"></i>
                                    <span>Clique para selecionar uma imagem</span>
                                </div>
                                <input type="file" id="imagem" name="imagem" accept="image/*" required>
                            </div>
                            <small class="form-text">Formatos aceitos: JPG, JPEG, PNG, GIF</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Vídeo do Módulo</label>
                            <div class="file-input-wrapper">
                                <div class="file-input-trigger">
                                    <i class="fas fa-video me-2"></i>
                                    <span>Clique para selecionar um vídeo</span>
                                </div>
                                <input type="file" id="video" name="video" accept="video/mp4,video/mov,video/avi" required>
                            </div>
                            <small class="form-text">Formatos aceitos: MP4, MOV, AVI</small>
                        </div>

                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-plus-circle me-2"></i>Adicionar Módulo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Atualizar o texto do trigger quando um arquivo for selecionado
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'Nenhum arquivo selecionado';
                this.previousElementSibling.querySelector('span').textContent = fileName;
            });
        });
    </script>
</body>
</html>
