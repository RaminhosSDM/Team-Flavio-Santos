<?php
require 'verificar_login.php';
include 'header.php';

// Debug da sessão
error_log("Estado da sessão no index: " . session_status());
error_log("Conteúdo da sessão no index: " . print_r($_SESSION, true));
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Team FlávioSantos</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="src/styles.css">
  <style>
    .about-section {
      padding: 5rem 0;
      background-color: #fff;
    }

    .about-overlay {
      background: #fff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
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

    .testimonial-avatar {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .testimonial-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .testimonial-info {
      flex: 1;
    }

    .testimonial-name {
      margin: 0;
      font-weight: 600;
      color: #2d2d2d;
    }

    .testimonial-role {
      margin: 0;
      color: #666;
      font-size: 0.9rem;
    }

    .testimonial-content {
      background: #f8f9fa;
      padding: 1rem;
      border-radius: 10px;
      position: relative;
    }

    .testimonial-content p {
      margin: 0;
      font-style: italic;
      color: #555;
    }

    .testimonial-card {
      background: white;
      padding: 1.5rem;
      border-radius: 15px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
      transform: translateY(-5px);
    }
  </style>
</head>

<body>
  <!-- Hero Section -->
  <section class="hero-section">
    <div class="overlay"></div>
    <div class="hero-text container">
      <h1 class="display-5 fw-bold">TEAM FLÁVIO SANTOS</h1>
      <p class="lead">Muay Thai & Kickboxing</p>
      <p class="fs-6 fw-light">
        Team Flávio Santos é dedicado ao ensino e prática de
        <span class="text-danger fw-semibold">Muay Thai</span> e
        <span class="text-danger fw-semibold">Kickboxing</span>.<br>
        Junte-se à nossa equipa unida, focada e determinada.
      </p>
      <p class="text-danger fw-bold mt-4">
        Garantimos: se vier experimentar, vai querer fazer parte da nossa família!
      </p>
    </div>
  </section>

  <!-- About Section -->
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
          <div class="about-overlay">
            <h2 class="fw-light mb-3">Sobre a <span class="text-danger">TEAM</span>.</h2>
            <p class="text-dark"><strong>TEAM FLÁVIO SANTOS</strong> foi fundado pelo Mestre Flávio Santos, dedicado ao ensino e treinamento de <span class="text-danger">Kickboxing</span> e <span class="text-danger">Muay Thai</span>.</p>
            <p class="text-dark">Nossa equipa valoriza acima de tudo a dedicação, disciplina e o crescimento pessoal de cada atleta.</p>
            <p class="text-dark">Com uma metodologia única e profissional, formamos atletas completos, tanto fisicamente quanto mentalmente.</p>
            <p class="mt-4 fw-bold text-dark">Treinamos como <span class="text-danger">TEAM</span>,<br>lutamos como <span class="text-danger">FAMÍLIA</span>!</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Schedules Section -->
  <section class="container my-5 py-5">
    <h2 class="text-center mb-5 fw-light">Horários<span class="text-danger">.</span></h2>
    <div class="row g-4 justify-content-center">

      <?php
      $days = [
        "SEGUNDA" => ["17h às 18h", "19h às 20h", "20h às 21h"],
        "TERÇA" => ["17h às 18h", "19h às 20h", "20h às 21h"],
        "QUARTA" => ["19h às 20h", "20h às 21h"],
        "QUINTA" => ["17h às 18h", "19h às 20h", "20h às 21h"],
        "SEXTA" => ["17h às 18h", "19h às 20h", "SPARRING: 20h às 21h"],
        "SÁBADO" => ["KIDS (4-10): 10h às 11h", "11h às 12h"]
      ];

      foreach ($days as $day => $classes) {
        echo '<div class="col-12 col-md-4 col-lg-3">
                  <div class="card text-center p-3 shadow">
                    <h5 class="text-danger">' . $day . '</h5>
                    <p class="text-muted">MUAY THAI / KICKBOXING</p>';
        foreach ($classes as $class) {
          echo "<p><strong>$class</strong></p>";
        }
        echo '</div></div>';
      }
      ?>

      <!-- Private Classes -->
      <div class="col-12 col-md-4 col-lg-3">
        <div class="card text-center p-3 shadow">
          <h5 class="text-danger">AULAS PARTICULARES</h5>
          <p class="text-muted">Segunda a Sábado</p>
          <p><strong>De acordo com agendamento</strong></p>
        </div>
      </div>

      <!-- First Class Free -->
      <div class="col-12 col-md-5">
        <div class="card text-center p-4 shadow bg-danger text-white">
          <h5>PRIMEIRA AULA GRÁTIS</h5>
          <p>Venha treinar conosco e conhecer nossa equipa.</p>
          <p>A primeira aula é gratuita e sem compromisso.</p>
          <p>Basta agendar o seu horário preferido e trazer roupas de treino (roupa confortável).</p>
        </div>
      </div>

      <!-- Booking Info -->
      <div class="col-12 col-md-5">
        <div class="card text-center p-4 shadow">
          <h5 class="text-danger">AGENDAMENTO DE AULAS</h5>
          <p>O número de alunos por turma é ilimitado.</p>
          <p>Para garantir sua vaga, entre em contato com o Mestre Flávio Santos:</p>
          <a href="https://wa.me/351929149631" class="text-danger">(+351) 929 149 631</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonial-section text-dark text-center px-3 py-5">
    <h2 class="mb-4 fw-light">O que dizem sobre nós<span class="text-danger">.</span></h2>
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        // Buscar avaliações da base de dados
        $sql_avaliacoes = "SELECT * FROM avaliacoes ORDER BY data_avaliacao DESC";
        $result_avaliacoes = $conn->query($sql_avaliacoes);
        
        if ($result_avaliacoes && $result_avaliacoes->num_rows > 0) {
            $avaliacoes = $result_avaliacoes->fetch_all(MYSQLI_ASSOC);
            $total_avaliacoes = count($avaliacoes);
            $avaliacoes_por_slide = 3;
            $total_slides = ceil($total_avaliacoes / $avaliacoes_por_slide);
            
            for ($i = 0; $i < $total_slides; $i++) {
                $active = $i === 0 ? 'active' : '';
                echo '<div class="carousel-item ' . $active . '">';
                echo '<div class="row g-4 justify-content-center">';
                
                for ($j = $i * $avaliacoes_por_slide; $j < min(($i + 1) * $avaliacoes_por_slide, $total_avaliacoes); $j++) {
                    $avaliacao = $avaliacoes[$j];
                    $data = new DateTime($avaliacao['data_avaliacao']);
                    $tempo = $data->diff(new DateTime())->format('%a');
                    $tempo_texto = $tempo == 0 ? 'Hoje' : ($tempo == 1 ? 'Ontem' : 'Há ' . $tempo . ' dias');
                    
                    echo '<div class="col-md-4">';
                    echo '<div class="testimonial-card">';
                    echo '<div class="testimonial-header">';
                    // Verifica se existe uma foto de perfil, senão usa uma imagem padrão
                    $foto_perfil = !empty($avaliacao['foto_perfil']) ? 'src/imgs/' . $avaliacao['foto_perfil'] : 'https://i.pravatar.cc/100?img=' . ($j % 6 + 1);
                    echo '<img src="' . htmlspecialchars($foto_perfil) . '" class="testimonial-avatar" alt="' . htmlspecialchars($avaliacao['nome']) . '">';
                    echo '<div class="testimonial-info">';
                    echo '<h5 class="testimonial-name">' . htmlspecialchars($avaliacao['nome']) . '</h5>';
                    echo '<p class="testimonial-role">' . $tempo_texto . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="testimonial-content">';
                    echo '<p>"' . htmlspecialchars($avaliacao['comentario']) . '"</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                
                echo '</div>';
                echo '</div>';
            }
        } else {
            // Se não houver avaliações, mostrar mensagem padrão
            echo '<div class="carousel-item active">';
            echo '<div class="row g-4 justify-content-center">';
            echo '<div class="col-12">';
            echo '<p class="text-muted">Seja o primeiro a deixar sua avaliação!</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
      </div>
      <?php if ($total_slides > 1): ?>
      <div class="carousel-indicators position-relative mt-4">
        <?php for ($i = 0; $i < $total_slides; $i++): ?>
          <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="<?php echo $i; ?>" <?php echo $i === 0 ? 'class="active"' : ''; ?> aria-label="Slide <?php echo $i + 1; ?>"></button>
        <?php endfor; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Formulário de Avaliações -->
  <section class="avaliacoes-section py-5">
    <div class="container">
      <h2 class="text-center mb-4 fw-light">Deixe sua Avaliação<span class="text-danger">.</span></h2>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow">
            <div class="card-body p-4">
              <?php if (isset($_SESSION['sucesso'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?php 
                    echo $_SESSION['sucesso'];
                    unset($_SESSION['sucesso']);
                  ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>

              <?php if (isset($_SESSION['erro'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php 
                    echo $_SESSION['erro'];
                    unset($_SESSION['erro']);
                  ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>

              <form action="salvar_avaliacao.php" method="POST">
                <div class="mb-3">
                  <label for="comentario" class="form-label">Sua Avaliação</label>
                  <textarea class="form-control" id="comentario" name="comentario" rows="4" required></textarea>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-danger px-4">Enviar Avaliação</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- News Section -->
  <section class="news-section py-5">
    <div class="container">
      <h2 class="text-center mb-5 fw-light">Notícias<span class="text-danger">.</span></h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="news-card">
            <div class="news-image">
            <img src="img/campeonato.jpeg" alt="campeonato" class="news-image">

              <div class="news-date">
                <span class="day">17</span>
                <span class="month">MAI</span>
              </div>
            </div>
            <div class="news-content">
              <h3>Campeonato Nacional de Muay Thai</h3>
              <p>Nossa equipa está a preparar-se para o Campeonato Nacional que acontecerá no próximo mês. Treinos intensivos e preparação mental em andamento!</p>
              <a href="https://www.instagram.com/p/DInyKEPi4r_/" target="_blank" class="news-link">Ler mais <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="news-card">
            <div class="news-image">
              <img src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Workshop Técnico">
              <div class="news-date">
                <span class="day">22</span>
                <span class="month">MAI</span>
              </div>
            </div>
            <div class="news-content">
              <h3>Workshop Técnico Especial</h3>
              <p>Workshop exclusivo com técnicas avançadas de Muay Thai e Kickboxing. Vagas limitadas para alunos e convidados.</p>
              <a href="#" class="news-link">Ler mais <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="news-card">
            <div class="news-image">
              <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Nova Turma">
              <div class="news-date">
                <span class="day">01</span>
                <span class="month">JUN</span>
              </div>
            </div>
            <div class="news-content">
              <h3>Nova Turma Iniciante</h3>
              <p>Inscrições abertas para nova turma de iniciantes. Aulas especiais para quem está começando no Muay Thai.</p>
              <a href="#" class="news-link">Ler mais <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Call to Action Section -->
  <section class="cta-section text-center px-3 py-5">
    <div class="container">
      <h2 class="cta-title mb-3">Do que está à espera para fazer parte desta família?</h2>
      <p class="cta-subtitle text-danger mb-4">Venha experimentar uma aula!</p>

      <p class="cta-text">Experimente sua primeira aula <strong>gratuitamente</strong>, sem compromisso!</p>
      <p class="cta-text">Entre em contato com nosso mestre <strong>Flávio Santos</strong> por telefone ou WhatsApp:</p>

      <p class="cta-contact">
        <a href="https://wa.me/351929149631" class="cta-link">(+351) 929149631</a>
      </p>
      <p class="cta-note">(Chamada para rede móvel portuguesa)</p>

      <hr class="my-4" style="opacity: 0.1;">

      <p class="cta-equip-title text-warning mb-2">Equipamento Necessário:</p>
      <p class="cta-text">Roupa de treino (confortável), toalha de rosto e, se tiver: Ligaduras, luvas, caneleiras.</p>
      <p class="cta-text">Não tem equipamento? Sem problemas — nós emprestamos!</p>
      <p class="cta-friend text-success mb-4">E sim, pode trazer um amigo!</p>

      <p class="cta-promo text-dark h5 mb-4">Descubra o que a <strong>Team Flávio Santos</strong> pode fazer por ti:</p>

      <div class="row justify-content-center mt-4 gx-4 gy-4">
        <div class="col-6 col-md-2 text-center">
          <i class="fas fa-heart cta-icon text-danger"></i>
          <p class="cta-benefit">Melhora a <strong>Saúde</strong></p>
        </div>
        <div class="col-6 col-md-2 text-center">
          <i class="fas fa-dumbbell cta-icon text-danger"></i>
          <p class="cta-benefit">Mais <strong>Força</strong></p>
        </div>
        <div class="col-6 col-md-2 text-center">
          <i class="fas fa-bolt cta-icon text-danger"></i>
          <p class="cta-benefit"><strong>Velocidade</strong></p>
        </div>
        <div class="col-6 col-md-2 text-center">
          <i class="fas fa-brain cta-icon text-danger"></i>
          <p class="cta-benefit"><strong>Foco</strong> Mental<br> & Alívio do Estresse</p>
        </div>
        <div class="col-6 col-md-2 text-center">
          <i class="fas fa-trophy cta-icon text-danger"></i>
          <p class="cta-benefit">Pronto para <strong>Competição</strong></p>
        </div>
      </div>

      <form action="register.php" method="GET">
        <button type="submit" class="btn btn-danger btn-lg mt-5 px-4 py-2 rounded-pill shadow">Junte-se Agora</button>
      </form>
    </div>
  </section>


  <!-- WhatsApp Button -->
  <a href="https://wa.me/351929149631" class="whatsapp" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" width="50" alt="WhatsApp">
  </a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>
</body>

</html>

<?php include 'footer.php'; ?>