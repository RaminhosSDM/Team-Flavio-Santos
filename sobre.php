<?php
require 'verificar_login.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Team Flávio Santos - Sobre Nós</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="src/styles.css">
  <style>
    .about-header {
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.85), rgba(220, 53, 69, 0.85)), url('img/sobre-bg.jpg');
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

    .about-header h1 span:not(.text-danger) {
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .about-header h1 span:not(.text-danger):hover {
      transform: scale(1.05);
      color: #ff4d4d;
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

    .about-header .text-danger::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100%;
      height: 3px;
      background: #ff4d4d;
      transform: scaleX(0);
      transform-origin: right;
      transition: transform 0.3s ease;
    }

    .about-header .text-danger:hover::after {
      transform: scaleX(1);
      transform-origin: left;
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

    .about-section {
      padding: 5rem 0;
      background-color: #fff;
      position: relative;
      z-index: 2;
      margin-top: -100px;
    }

    .about-content {
      background: #fff;
      padding: 2.5rem;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      position: relative;
      z-index: 3;
    }

    .master-image-container {
      position: relative;
      max-width: 400px;
      margin: 0 auto;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .master-image {
      width: 100%;
      height: auto;
      display: block;
    }

    .master-image-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
      padding: 2rem 1rem 1rem;
      color: #fff;
      transform: translateY(-50px);
    }

    .master-name {
      font-size: 1.8rem;
      margin: 0;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    .master-title {
      font-size: 1.2rem;
      font-weight: 300;
      margin: 0;
      opacity: 0.9;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    .values-section {
      padding: 5rem 0;
      background-color: #f8f9fa;
    }

    .value-card {
      background: #fff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      text-align: center;
      height: 100%;
      transition: transform 0.3s ease;
    }

    .value-card:hover {
      transform: translateY(-5px);
    }

    .value-icon {
      font-size: 2.5rem;
      color: #dc3545;
      margin-bottom: 1rem;
    }

    .value-title {
      color: #333;
      margin-bottom: 1rem;
    }

    .value-description {
      color: #666;
    }

    .team-section {
      padding: 5rem 0;
      background-color: #fff;
    }

    .team-member {
      background: #fff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      text-align: center;
      margin-bottom: 2rem;
    }

    .team-member img {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 1.5rem;
      border: 5px solid #dc3545;
    }

    /* Estilo específico para a foto do David */
    .team-member img[alt="Professor David Carapinha"] {
      object-position: 0 -30px; /* Ajusta a posição vertical da imagem */
    }

    .team-member h4 {
      color: #333;
      margin-bottom: 0.5rem;
    }

    .team-member p {
      color: #666;
    }

    @media (max-width: 768px) {
      .master-image-container {
        max-width: 300px;
        margin-bottom: 2rem;
      }

      .master-name {
        font-size: 1.6rem;
      }

      .master-title {
        font-size: 1.1rem;
      }

      .master-image-overlay {
        padding: 2rem 1rem 1rem;
      }
    }
  </style>
</head>

<body>
  <div class="about-header text-center">
    <div class="container">
      <h1 class="display-4 fw-bold mb-4"><span>Team</span> <span class="text-danger">Flávio Santos</span></h1>
      <p class="lead">Mais que um ginásio, uma família unida pela paixão das artes marciais</p>
    </div>
  </div>

  <section class="about-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 text-center mb-4 mb-md-0">
          <div class="master-image-container">
            <img src="img/flavio.png" alt="Mestre Flávio Santos" class="master-image">
            <div class="master-image-overlay">
              <h3 class="master-name">Mestre Flávio Santos</h3>
              <p class="master-title">Fundador & Treinador Principal</p>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="about-content">
            <h2 class="fw-light mb-4">A nossa <span class="text-danger">História</span></h2>
            <p class="lead mb-4">A <strong>Team Flávio Santos</strong> foi fundado com a missão de ensinar e promover o <span class="text-danger">Muay Thai</span> e o <span class="text-danger">Kickboxing</span> com excelência e dedicação.</p>
            <p class="text-dark">A nossa equipa valoriza acima de tudo a dedicação, disciplina e o crescimento pessoal de cada atleta. Com uma metodologia única e profissional, formamos atletas completos, tanto fisicamente quanto mentalmente.</p>
            <p class="mt-4 fw-bold text-dark">Treinamos como <span class="text-danger">TEAM</span>,<br>lutamos como <span class="text-danger">FAMÍLIA</span>!</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="values-section">
    <div class="container">
      <h2 class="text-center mb-5 fw-light">Os nossos <span class="text-danger">Valores</span></h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="value-card">
            <i class="fas fa-heart value-icon"></i>
            <h3 class="value-title">Dedicação</h3>
            <p class="value-description">Comprometimento total com o desenvolvimento de cada aluno, respeitando os seus limites e objetivos.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="value-card">
            <i class="fas fa-fist-raised value-icon"></i>
            <h3 class="value-title">Disciplina</h3>
            <p class="value-description">Cultivamos a disciplina como base para o sucesso, tanto dentro quanto fora do tatame.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="value-card">
            <i class="fas fa-users value-icon"></i>
            <h3 class="value-title">Família</h3>
            <p class="value-description">Criamos um ambiente acolhedor onde todos são bem-vindos e fazem parte da nossa família.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="team-section">
    <div class="container">
      <h2 class="text-center mb-5 fw-light">Nossa <span class="text-danger">Equipa</span></h2>
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="team-member">
            <img src="img/flavio.png" alt="Mestre Flávio Santos">
            <h4>Mestre Flávio Santos</h4>
            <p>Fundador & Treinador Principal</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="team-member">
            <img src="img/david.jpeg" alt="Professor David Carapinha">
            <h4>Professor David Carapinha</h4>
            <p>Treinador de Kickboxing</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="team-member">
            <img src="img/jose.jpeg" alt="Professor José Ferreira">
            <h4>Professor José Ferreira</h4>
            <p>Treinador de Muay Thai</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'footer.php'; ?>