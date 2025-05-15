<?php
include 'header.php';

// Verificar se há erro na URL
if (isset($_GET['error'])) {
    $error = "Email ou senha incorretos";
}
?>

<div class="auth-container mt-5 pt-5">
  <div class="auth-card">
    <div class="auth-header">
      <img src="img/logoteam.png" alt="Logo" style="height: 50px;">
      <h2>Login</h2>
    </div>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="process_login.php">
      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="text-end mt-1">
          <a href="recuperar_senha.php" class="text-danger small">Esqueceu a senha?</a>
        </div>
      </div>

      <button type="submit" class="btn btn-auth">Entrar</button>
    </form>

    <div class="auth-footer">
      <p>Não tem uma conta? <a href="register.php">Registre-se</a></p>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
