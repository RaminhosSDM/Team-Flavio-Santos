<?php
session_start();
require 'conexao.php';

// Verifica se está logado
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

// Verifica se é o admin (id 1)
if ($_SESSION['id_user'] != 1) {
    // Estilo para erro
    echo '
    <!DOCTYPE html>
    <html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Acesso Negado</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <style>
            body {
                background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            }
            .error-card {
                background: white;
                padding: 3rem;
                border-radius: 1.5rem;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                text-align: center;
                max-width: 500px;
                width: 90%;
                transform: translateY(-20px);
                animation: fadeIn 0.5s ease-out;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(0); }
                to { opacity: 1; transform: translateY(-20px); }
            }
            .error-card h1 {
                font-size: 3.5rem;
                color: #dc3545;
                margin-bottom: 1rem;
            }
            .error-card p {
                margin-top: 1rem;
                font-size: 1.2rem;
                color: #6c757d;
            }
            .btn-back {
                margin-top: 2rem;
                padding: 0.8rem 2rem;
                border-radius: 50px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .btn-back:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            }
        </style>
    </head>
    <body>
        <div class="error-card">
            <h1><i class="fas fa-exclamation-circle mb-3"></i><br>Acesso Negado</h1>
            <p>Você não tem permissão para aceder a esta página.</p>
            <a href="index.php" class="btn btn-danger btn-back">
                <i class="fas fa-home me-2"></i>Voltar para a página inicial
            </a>
        </div>
    </body>
    </html>
    ';
    exit();
}

// Buscar utilizadores
$users = $conn->query("SELECT * FROM users");

// Buscar módulos
$modulos = $conn->query("SELECT * FROM modulos");

if (!$users || !$modulos) {
    die("Erro ao buscar dados: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #343a40 0%, #212529 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
            background: white;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #343a40 0%, #212529 100%);
            color: white;
            border-radius: 1rem 1rem 0 0 !important;
            padding: 1.5rem;
            border-bottom: none;
        }

        .card-header h2 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #343a40;
            color: white;
            font-weight: 500;
            border: none;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: background-color 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(0,0,0,0.02);
        }

        .btn-custom {
            width: 100px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-group-fixed {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        .btn-group-fixed .btn {
            border-radius: 50px;
            padding: 0.8rem 1.5rem;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }

        .btn-group-fixed .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
        }

        .table-responsive {
            border-radius: 0 0 1rem 1rem;
            overflow: hidden;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .stats-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #343a40;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .module-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="dashboard-header">
    <div class="container">
        <h1 class="dashboard-title text-center">
            <i class="fas fa-tachometer-alt me-2"></i>Painel de Administração
        </h1>
    </div>
</div>

<div class="container">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <i class="fas fa-users stats-icon"></i>
                <div class="stats-number"><?= $users->num_rows ?></div>
                <div class="stats-label">Utilizadores</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <i class="fas fa-video stats-icon"></i>
                <div class="stats-number"><?= $modulos->num_rows ?></div>
                <div class="stats-label">Módulos</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <i class="fas fa-heart stats-icon"></i>
                <div class="stats-number">
                    <?php
                    $favoritos = $conn->query("SELECT COUNT(*) as total FROM modulos WHERE favorito = 1");
                    echo $favoritos->fetch_assoc()['total'];
                    ?>
                </div>
                <div class="stats-label">Favoritos</div>
            </div>
        </div>
    </div>

    <!-- Utilizadores -->
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-users me-2"></i>Utilizadores</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $user['id_user'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="editar_user.php?id=<?= $user['id_user'] ?>" class="btn btn-warning btn-sm btn-custom">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                <a href="remover_user.php?id=<?= $user['id_user'] ?>" class="btn btn-danger btn-sm btn-custom" 
                                   onclick="return confirm('Tem a certeza que deseja remover este utilizador?')">
                                    <i class="fas fa-trash me-1"></i>Remover
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Módulos -->
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-video me-2"></i>Módulos</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="adicionar_modulo.php" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i>Novo Módulo
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($modulo = $modulos->fetch_assoc()): ?>
                        <tr>
                            <td><?= $modulo['id_modulo'] ?></td>
                            <td>
                                <img src="src/imgs/<?= htmlspecialchars($modulo['imagem_modulo']) ?>" 
                                     alt="<?= htmlspecialchars($modulo['nome_modulo']) ?>"
                                     class="module-image">
                            </td>
                            <td><?= htmlspecialchars($modulo['nome_modulo']) ?></td>
                            <td><?= htmlspecialchars($modulo['descricao_modulo']) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="editar_modulo.php?id=<?= $modulo['id_modulo'] ?>" class="btn btn-warning btn-sm btn-custom">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </a>
                                    <a href="remover_modulo.php?id=<?= $modulo['id_modulo'] ?>" class="btn btn-danger btn-sm btn-custom"
                                       onclick="return confirm('Tem a certeza que deseja remover este módulo?')">
                                        <i class="fas fa-trash me-1"></i>Remover
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Botões Fixos no Canto -->
<div class="btn-group-fixed">
    <a href="index.php" class="btn btn-primary">
        <i class="fas fa-home me-1"></i>Voltar
    </a>
    <a href="logout.php" class="btn btn-danger">
        <i class="fas fa-sign-out-alt me-1"></i>Logout
    </a>
</div>

</body>
</html>

