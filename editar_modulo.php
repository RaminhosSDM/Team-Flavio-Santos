<?php
require 'verificar_login.php';
require 'conexao.php';

// Verifica se o usuário está logado e é administrador (id_user = 1)
if (!isset($_SESSION['id_user']) || $_SESSION['id_user'] != 1) {
    header("Location: index.php");
    exit();
}

include 'navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $nivel = $_POST['nivel'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $targetDir = "src/imgs/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        $safeImageName = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', basename($_FILES['imagem']['name']));
        $targetFile = $targetDir . $safeImageName;

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedImageTypes = ['jpg', 'png', 'jpeg', 'gif'];

        if (in_array($imageFileType, $allowedImageTypes)) {
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $targetFile)) {
                $sql = "UPDATE modulos SET nome_modulo = ?, descricao_modulo = ?, imagem_modulo = ?, nivel_modulo = ? WHERE id_modulo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $nome, $descricao, $safeImageName, $nivel, $id);
                
                if ($stmt->execute()) {
                    header('Location: dashboard.php');
                    exit();
                } else {
                    echo "Erro ao atualizar o módulo: " . $stmt->error;
                }
            } else {
                echo "Erro ao mover o arquivo para o diretório.";
            }
        } else {
            echo "Somente arquivos de imagem (JPG, PNG, JPEG, GIF) são permitidos.";
        }
    } else {
        // Se não houver nova imagem, atualiza apenas os outros campos
        $sql = "UPDATE modulos SET nome_modulo = ?, descricao_modulo = ?, nivel_modulo = ? WHERE id_modulo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nome, $descricao, $nivel, $id);
        
        if ($stmt->execute()) {
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Erro ao atualizar o módulo: " . $stmt->error;
        }
    }
}

// Verifica se o ID foi passado na URL
if (!isset($_GET['id'])) {
    echo "ID do módulo não fornecido.";
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM modulos WHERE id_modulo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$modulo = $result->fetch_assoc();

// Verifica se o módulo existe
if (!$modulo) {
    echo "Módulo não encontrado.";
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Módulo - Team Flávio Santos</title>
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

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-secondary, .btn-submit {
            flex: 1;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            border: none;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-submit {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
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

        .current-image {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: center;
        }

        .current-image img {
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-card">
                    <h2><i class="fas fa-edit me-2"></i>Editar Módulo</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $modulo['id_modulo']; ?>">
                        
                        <div class="mb-4">
                            <label for="nome" class="form-label">
                                <i class="fas fa-heading me-2"></i>Nome do Módulo
                            </label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?php echo htmlspecialchars($modulo['nome_modulo']); ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="descricao" class="form-label">
                                <i class="fas fa-align-left me-2"></i>Descrição
                            </label>
                            <textarea class="form-control" id="descricao" name="descricao" 
                                      rows="4" required><?php echo htmlspecialchars($modulo['descricao_modulo']); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="nivel" class="form-label">
                                <i class="fas fa-signal me-2"></i>Nível do Módulo
                            </label>
                            <select class="form-select" id="nivel" name="nivel" required>
                                <option value="Iniciante" <?php echo $modulo['nivel_modulo'] == 'Iniciante' ? 'selected' : ''; ?>>Iniciante</option>
                                <option value="Intermediário" <?php echo $modulo['nivel_modulo'] == 'Intermediário' ? 'selected' : ''; ?>>Intermediário</option>
                                <option value="Avançado" <?php echo $modulo['nivel_modulo'] == 'Avançado' ? 'selected' : ''; ?>>Avançado</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-image me-2"></i>Imagem do Módulo
                            </label>
                            <div class="file-input-wrapper">
                                <div class="file-input-trigger">
                                    <i class="fas fa-image me-2"></i>
                                    <span>Clique para selecionar uma nova imagem</span>
                                </div>
                                <input type="file" id="imagem" name="imagem" accept="image/*">
                            </div>
                            <small class="form-text">Formatos aceitos: JPG, PNG, JPEG, GIF</small>
                            
                            <div class="current-image">
                                <img src="src/imgs/<?php echo htmlspecialchars($modulo['imagem_modulo']); ?>" 
                                     alt="Imagem atual" class="img-fluid">
                                <small class="d-block text-muted mt-2">Imagem atual do módulo</small>
                            </div>
                        </div>
                        
                        <div class="btn-group">
                            <a href="dashboard.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                <span>Voltar</span>
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-save"></i>
                                <span>Salvar Alterações</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'Nenhum arquivo selecionado';
                this.previousElementSibling.querySelector('span').textContent = fileName;
            });
        });
    </script>
</body>
</html>
