<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="img/logoteam.png" alt="Team Logo" class="navbar-logo" style="height: 50px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">
            <i class="fas fa-home me-1"></i>Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'modulos.php' ? 'active' : '' ?>" href="modulos.php">
            <i class="fas fa-video me-1"></i>Aulas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'sobre.php' ? 'active' : '' ?>" href="sobre.php">
            <i class="fas fa-info-circle me-1"></i>Sobre Nós
          </a>
        </li>

        <?php if (isset($_SESSION['id_user'])): ?>
          <?php if ($_SESSION['id_user'] == 1): ?>
            <li class="nav-item">
              <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
              </a>
            </li>
          <?php endif; ?>
          
          <li class="nav-item dropdown">
            <button class="btn btn-link nav-link dropdown-toggle d-flex align-items-center" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <?php if (isset($_SESSION['imagem_user']) && file_exists('src/imgs/' . $_SESSION['imagem_user'])): ?>
                <img src="src/imgs/<?php echo $_SESSION['imagem_user']; ?>" 
                     alt="Perfil" 
                     class="profile-img me-2">
              <?php else: ?>
                <div class="default-avatar me-2">
                  <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
              <?php endif; ?>
              <span class="d-none d-lg-inline"><?php echo $_SESSION['username']; ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li>
                <a class="dropdown-item" href="perfil.php">
                  <i class="fas fa-user me-2"></i>Meu Perfil
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="logout.php">
                  <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
              </li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : '' ?>" href="login.php">
              <i class="fas fa-sign-in-alt me-1"></i>Login
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : '' ?>" href="register.php">
              <i class="fas fa-user-plus me-1"></i>Registar
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
