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
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $sql = "UPDATE users SET username = ?, email = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $email, $id);
    
    if ($stmt->execute()) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Erro ao atualizar o usuário: " . $stmt->error;
    }
}

// Verifica se o ID foi passado na URL
if (!isset($_GET['id'])) {
    echo "ID do usuário não fornecido.";
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verifica se o usuário existe
if (!$user) {
    echo "Usuário não encontrado.";
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuário - Team Flávio Santos</title>
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

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
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
                    <h2><i class="fas fa-user-edit me-2"></i>Editar Usuário</h2>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $user['id_user']; ?>">
                        
                        <div class="mb-4">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-2"></i>Nome de Usuário
                            </label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
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
</body>
</html> 