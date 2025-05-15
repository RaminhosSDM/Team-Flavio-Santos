<?php
require 'verificar_login.php';
require 'conexao.php';

// Debug da conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Primeiro, vamos verificar todos os módulos existentes
$sql_debug = "SELECT * FROM modulos";
$result_debug = $conn->query($sql_debug);
error_log("Total de módulos na tabela: " . ($result_debug ? $result_debug->num_rows : 0));

// Buscar módulos agrupados por nível
$sql = "SELECT * FROM modulos ORDER BY 
    CASE 
        WHEN nivel_modulo LIKE '%Iniciante%' THEN 1
        WHEN nivel_modulo LIKE '%Intermediário%' THEN 2
        WHEN nivel_modulo LIKE '%Avançado%' THEN 3
        WHEN nivel_modulo LIKE '%Competição%' THEN 4
        WHEN nivel_modulo LIKE '%Força%' THEN 5
        ELSE 6
    END";

// Debug da query
error_log("Query SQL: " . $sql);

$result = $conn->query($sql);

// Organizar módulos por nível
$modulos_por_nivel = [];
if ($result) {
    while($row = $result->fetch_assoc()) {
        $nivel = $row['nivel_modulo'];
        if (!isset($modulos_por_nivel[$nivel])) {
            $modulos_por_nivel[$nivel] = [];
        }
        $modulos_por_nivel[$nivel][] = $row;
    }
}

// Buscar aulas para cada módulo
$sql_aulas = "SELECT a.*, m.nivel_modulo 
              FROM aulas a 
              JOIN modulos m ON a.id_modulo = m.id_modulo 
              ORDER BY a.ordem_aula";
$result_aulas = $conn->query($sql_aulas);

$aulas_por_nivel = [];
if ($result_aulas) {
    while($row = $result_aulas->fetch_assoc()) {
        $nivel = $row['nivel_modulo'];
        if (!isset($aulas_por_nivel[$nivel])) {
            $aulas_por_nivel[$nivel] = [];
        }
        $aulas_por_nivel[$nivel][] = $row;
    }
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Módulos - Team Flávio Santos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="src/styles.css">
    <style>
        body {
            background: #f8f9fa;
            padding-bottom: 50px;
        }

        .about-header {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.85), rgba(220, 53, 69, 0.85)), url('img/modulos-bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 12rem 0 8rem;
            position: relative;
            overflow: hidden;
            margin-bottom: 0;
        }

        .about-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px;
            background: linear-gradient(to top, #fff, transparent);
            z-index: 1;
        }

        .about-header .container {
            position: relative;
            z-index: 2;
        }

        .about-header h1 {
            font-size: 4rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 1s ease;
        }

        .about-header .lead {
            font-size: 1.5rem;
            font-weight: 300;
            max-width: 800px;
            margin: 0 auto;
            opacity: 0.9;
            animation: fadeInUp 1s ease 0.3s;
            animation-fill-mode: both;
        }

        .about-header .text-danger {
            color: #ff4d4d !important;
            position: relative;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .about-header .text-danger:hover {
            transform: scale(1.05);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .about-header {
                padding: 8rem 0 6rem;
            }

            .about-header h1 {
                font-size: 2.5rem;
            }

            .about-header .lead {
                font-size: 1.2rem;
            }
        }

        .module-card {
            border: none;
            border-radius: 15px;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .module-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            transition: all 0.3s ease;
        }

        .module-card.iniciante::before {
            background: linear-gradient(to bottom, #dc3545, #c82333);
        }

        .module-card.intermediario::before {
            background: linear-gradient(to bottom, #28a745, #218838);
        }

        .module-card.avancado::before {
            background: linear-gradient(to bottom, #007bff, #0056b3);
        }

        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .module-card:hover::before {
            width: 8px;
        }

        .card-body {
            padding: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .module-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #2d2d2d;
        }

        .module-level {
            font-size: 0.9rem;
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            display: inline-block;
            margin-bottom: 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .module-level.iniciante {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .module-level.intermediario {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .module-level.avancado {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
        }

        .module-description {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            flex: 1;
        }

        .module-info {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .module-info-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: #555;
        }

        .module-info-item i {
            font-size: 1.2rem;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .module-info-item.iniciante i {
            color: #dc3545;
        }

        .module-info-item.intermediario i {
            color: #28a745;
        }

        .module-info-item.avancado i {
            color: #007bff;
        }

        .btn-module {
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            margin-top: auto;
        }

        .btn-module::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-module:hover::before {
            left: 100%;
        }

        .btn-module.iniciante {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .btn-module.intermediario {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .btn-module.avancado {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
        }

        .btn-module:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 2rem;
            color: #2d2d2d;
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, #dc3545, #c82333);
            border-radius: 2px;
        }

        .section-title.iniciante::after {
            background: linear-gradient(to right, #dc3545, #c82333);
        }

        .section-title.intermediario::after {
            background: linear-gradient(to right, #28a745, #218838);
        }

        .section-title.avancado::after {
            background: linear-gradient(to right, #007bff, #0056b3);
        }

        .favorite-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6c757d;
            transition: all 0.3s ease;
            padding: 0.5rem;
            margin-right: 1rem;
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .favorite-btn:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }

        .favorite-btn.active {
            color: #ffc107;
            background: rgba(255, 193, 7, 0.1);
        }

        .favorite-btn.active:hover {
            background: rgba(255, 193, 7, 0.2);
        }

        .favorites-section {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 3rem;
        }

        .favorites-section h2 {
            color: #2d2d2d;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .favorites-section h2 i {
            color: #ffc107;
        }

        .favorites-section:empty {
            display: none;
        }

        .module-section {
            margin-bottom: 5rem;
            padding: 2rem 0;
        }

        .module-section:nth-child(even) {
            background: #f8f9fa;
        }

        .video-preview {
            width: 200px;
            height: 120px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
            background: #000;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .video-preview:hover {
            transform: scale(1.05);
        }

        .video-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .video-preview:hover img {
            transform: scale(1.1);
        }

        .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: all 0.3s ease;
        }

        .video-preview:hover .play-overlay {
            background: rgba(0,0,0,0.5);
        }

        .play-overlay i {
            color: white;
            font-size: 2rem;
            z-index: 2;
            transition: transform 0.3s ease;
        }

        .video-preview:hover .play-overlay i {
            transform: scale(1.2);
        }

        .aulas-dropdown {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin: 2rem 0;
            overflow: hidden;
        }

        .aulas-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .aulas-header:hover {
            background: linear-gradient(135deg, #e9ecef, #dee2e6);
        }

        .aulas-header h3 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 600;
            color: #2d2d2d;
        }

        .aulas-header .count {
            background: #dc3545;
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .aulas-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .aulas-content.active {
            max-height: 1000px;
        }

        .aula-item {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        .aula-item:last-child {
            border-bottom: none;
        }

        .aula-item:hover {
            background: #f8f9fa;
        }

        .aula-number {
            width: 40px;
            height: 40px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .aula-info {
            flex: 1;
        }

        .aula-title {
            font-weight: 600;
            color: #2d2d2d;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        .aula-description {
            color: #666;
            font-size: 1rem;
            line-height: 1.5;
        }

        .aula-actions {
            display: flex;
            gap: 1rem;
            flex-shrink: 0;
        }

        .aula-btn {
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .aula-btn.play {
            background: #dc3545;
            color: white;
        }

        .aula-btn.play:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .aula-btn.details {
            background: #f8f9fa;
            color: #2d2d2d;
        }

        .aula-btn.details:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-stats {
            background: white;
            padding: 1rem 2rem;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .section-stats span {
            font-weight: 600;
            color: #dc3545;
        }

        .module-list {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin: 2rem 0;
            overflow: hidden;
        }

        .module-list-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .module-list-header h3 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 600;
            color: #2d2d2d;
        }

        .module-list-header .count {
            background: #dc3545;
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .module-item {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        .module-item:last-child {
            border-bottom: none;
        }

        .module-item:hover {
            background: #f8f9fa;
            transform: translateX(10px);
        }

        .module-number {
            width: 40px;
            height: 40px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .module-info {
            flex: 1;
        }

        .module-title {
            font-weight: 600;
            color: #2d2d2d;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        .module-description {
            color: #666;
            font-size: 1rem;
            line-height: 1.5;
        }

        .module-actions {
            display: flex;
            gap: 1rem;
            flex-shrink: 0;
        }

        .module-btn {
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .module-btn.play {
            background: #dc3545;
            color: white;
        }

        .module-btn.play:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .module-btn.details {
            background: #f8f9fa;
            color: #2d2d2d;
        }

        .module-btn.details:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-stats {
            background: white;
            padding: 1rem 2rem;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .section-stats span {
            font-weight: 600;
            color: #dc3545;
        }

        .module-section {
            margin-bottom: 5rem;
            padding: 2rem 0;
        }

        .module-section:nth-child(even) {
            background: #f8f9fa;
        }

        /* Estilos do Modal de Vídeo */
        .modal-content {
            background: #000;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .modal-header {
            background: linear-gradient(to right, #1a1a1a, #2d2d2d);
            border-bottom: 1px solid #333;
            color: white;
            padding: 0.8rem;
            position: relative;
        }

        .modal-header .modal-title {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .modal-body {
            padding: 0;
            background: #000;
        }

        .ratio-16x9 {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
        }

        .ratio-16x9 video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Responsividade */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.3rem;
            }
            
            .modal-header {
                padding: 0.6rem;
            }

            .modal-header .modal-title {
                font-size: 0.9rem;
            }

            .modal-header .btn-close {
                padding: 0.2rem;
                background-size: 0.7rem;
            }
        }

        .favorite-card {
            position: relative;
            transition: all 0.3s ease;
        }

        .favorite-card:hover {
            transform: translateY(-5px);
        }

        .favorite-card .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2;
        }

        .favorite-card .favorite-btn.active {
            animation: pulse 0.3s ease;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="about-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Módulos de <span class="text-danger">Treino</span></h1>
            <p class="lead">Descubra sua jornada no Muay Thai com nossos módulos exclusivos, desenvolvidos para todos os níveis de experiência.</p>
        </div>
    </div>

    <div class="container">
        <!-- Seção de Favoritos -->
        <div class="favorites-section mb-4">
            <h2><i class="fas fa-star"></i> Módulos Favoritos</h2>
            <div class="row" id="favoritos-container">
                <!-- Os módulos favoritos serão carregados aqui via JavaScript -->
            </div>
        </div>

        <?php foreach ($modulos_por_nivel as $nivel => $modulos): 
            $nivel_class = strtolower(str_replace(['ç', 'á', 'é', 'í', 'ó', 'ú', 'ã', 'õ'], ['c', 'a', 'e', 'i', 'o', 'u', 'a', 'o'], $nivel));
            $total_modulos = count($modulos);
        ?>
            <section class="module-section">
                <div class="section-header">
                    <h2 class="section-title <?= $nivel_class ?>"><?= htmlspecialchars($nivel) ?></h2>
                    <div class="section-stats">
                        Total de Módulos: <span><?= $total_modulos ?></span>
                    </div>
                </div>

                <!-- Lista de Módulos -->
                <div class="module-list">
                    <div class="module-list-header">
                        <h3>Módulos Disponíveis</h3>
                        <span class="count"><?= $total_modulos ?> módulos</span>
                    </div>
                    <?php foreach ($modulos as $index => $modulo): ?>
                        <div class="module-item">
                            <div class="module-number"><?= $index + 1 ?></div>
                            <?php if (!empty($modulo['id_modulo'])): ?>
                                <div class="video-preview">
                                    <?php 
                                    $imagem_modulo = 'src/imgs/' . $modulo['imagem_modulo'];
                                    echo '<img src="' . htmlspecialchars($imagem_modulo) . '" alt="Preview do Módulo ' . htmlspecialchars($modulo['nome_modulo']) . '" style="width: 100%; height: 100%; object-fit: cover;">';
                                    ?>
                                    <div class="play-overlay">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="module-info">
                                <div class="module-title"><?= htmlspecialchars($modulo['nome_modulo']) ?></div>
                                <div class="module-description"><?= htmlspecialchars($modulo['descricao_modulo']) ?></div>
                            </div>
                            <div class="module-actions">
                                <button class="favorite-btn" 
                                        data-id="<?= $modulo['id_modulo'] ?>"
                                        data-favorito="<?= $modulo['favorito'] ?? 0 ?>">
                                    <i class="fas fa-star"></i>
                                </button>
                                <button class="module-btn play" onclick="playModulo(<?= $modulo['id_modulo'] ?>, '<?= htmlspecialchars($modulo['video_modulo']) ?>', '<?= htmlspecialchars($modulo['nome_modulo']) ?>')">
                                    <i class="fas fa-play"></i> Assistir
                                </button>
                                <button class="module-btn details" onclick="showModuloDetails(<?= $modulo['id_modulo'] ?>)">
                                    <i class="fas fa-info-circle"></i> Detalhes
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    </div>

    <!-- Modal de Vídeo -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Assistir Módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <video id="videoPlayer" controls>
                            <source src="" type="video/mp4">
                            Seu navegador não suporta vídeos HTML5.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleFavorite(button) {
            const id = button.dataset.id;
            const currentState = button.dataset.favorito === "1";
            const newState = !currentState;

            fetch('toggle_favorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_modulo=${id}&favorito=${newState ? 1 : 0}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Atualizar todos os botões com o mesmo ID
                    document.querySelectorAll(`.favorite-btn[data-id="${id}"]`).forEach(btn => {
                        updateFavoriteButton(btn, newState);
                    });
                    
                    // Se estiver na seção de favoritos e desmarcou, remover o card
                    if (!newState && button.closest('.favorite-card')) {
                        button.closest('.favorite-card').remove();
                    }
                    
                    loadFavorites();
                } else {
                    alert('Erro ao atualizar favorito');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao atualizar favorito');
            });
        }

        function toggleAulas(header) {
            const content = header.nextElementSibling;
            content.classList.toggle('active');
        }

        function playModulo(idModulo, videoPath, moduloTitle) {
            // Abrir o modal
            const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
            videoModal.show();
            
            // Atualizar o título do modal
            document.getElementById('videoModalLabel').textContent = moduloTitle;
            
            // Atualizar o vídeo com o caminho exato da base de dados
            const videoPlayer = document.getElementById('videoPlayer');
            videoPlayer.querySelector('source').src = videoPath;
            videoPlayer.load();
            videoPlayer.play();
        }

        function showModuloDetails(idModulo) {
            // Implementar a lógica para mostrar detalhes do módulo
            console.log('Mostrar detalhes do módulo:', idModulo);
        }

        function scrollToModules() {
            const firstModule = document.querySelector('.module-section');
            if (firstModule) {
                firstModule.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function showMoreInfo() {
            // Implementar lógica para mostrar mais informações
            alert('Em breve: Mais informações sobre nossos módulos!');
        }

        // Pausar o vídeo quando o modal for fechado
        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
            const videoPlayer = document.getElementById('videoPlayer');
            videoPlayer.pause();
        });

        // Função para atualizar o estado do botão de favorito
        function updateFavoriteButton(button, isFavorite) {
            button.dataset.favorito = isFavorite ? "1" : "0";
            button.classList.toggle('active', isFavorite);
        }

        // Função para carregar os módulos favoritos
        function loadFavorites() {
            const favoritosContainer = document.getElementById('favoritos-container');
            const cards = document.querySelectorAll('.module-item');
            
            // Limpar o container de favoritos
            favoritosContainer.innerHTML = '';
            
            // Criar um Set para armazenar IDs únicos
            const favoritosIds = new Set();
            
            cards.forEach(card => {
                const favoriteBtn = card.querySelector('.favorite-btn');
                if (favoriteBtn && favoriteBtn.dataset.favorito === "1") {
                    const id = favoriteBtn.dataset.id;
                    // Verificar se o ID já foi adicionado
                    if (!favoritosIds.has(id)) {
                        favoritosIds.add(id);
                        const clone = card.cloneNode(true);
                        
                        // Adicionar classe especial para o card na seção de favoritos
                        clone.classList.add('favorite-card');
                        
                        // Remover eventos duplicados e adicionar novo botão de favorito
                        const newFavoriteBtn = clone.querySelector('.favorite-btn');
                        if (newFavoriteBtn) {
                            const btnClone = favoriteBtn.cloneNode(true);
                            btnClone.addEventListener('click', function() {
                                toggleFavorite(this);
                            });
                            newFavoriteBtn.replaceWith(btnClone);
                        }
                        
                        favoritosContainer.appendChild(clone);
                    }
                }
            });

            // Esconder a seção de favoritos se não houver favoritos
            const favoritesSection = document.querySelector('.favorites-section');
            if (favoritosIds.size === 0) {
                favoritesSection.style.display = 'none';
            } else {
                favoritesSection.style.display = 'block';
            }
        }

        // Adicionar evento de clique para os botões de favorito
        document.querySelectorAll('.favorite-btn').forEach(button => {
            button.addEventListener('click', function() {
                toggleFavorite(this);
            });

            // Inicializar estado do botão
            updateFavoriteButton(button, button.dataset.favorito === "1");
        });

        // Carregar favoritos iniciais
        loadFavorites();
    </script>
</body>
</html>