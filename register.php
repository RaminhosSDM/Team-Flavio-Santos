<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $imagem_user = 'default_profile.png'; // Imagem padrão

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, imagem_user) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $imagem_user);

    if ($stmt->execute()) {
        $success = "Usuário registrado com sucesso!";
    } else {
        $error = "Erro ao registrar: " . $stmt->error;
    }
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - PapRamos</title>
    <link rel="stylesheet" href="src/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-page">

<div class="auth-container">
  <a href="index.php" class="home-icon">
    <i class="fas fa-home"></i>
  </a>
  <div class="auth-card">
    <div class="auth-header">
      <img src="img/logoteam.png" alt="Logo" style="height: 50px;">
      <h2>Registro</h2>
    </div>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
      <div class="alert alert-success">
        <?php echo $success; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="username" class="form-label">Nome de Usuário</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>

      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <button type="submit" class="btn btn-auth">Registrar</button>
    </form>

    <div class="auth-footer">
      <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
