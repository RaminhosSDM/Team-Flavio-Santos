<?php
require 'conexao.php';
include 'header.php';

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Verificar se o email existe no banco de dados
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Gerar token único
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Salvar token no banco de dados
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expiry, $email);
        
        if ($stmt->execute()) {
            // Aqui você pode adicionar o código para enviar o email com o link de recuperação
            // Por enquanto, vamos apenas mostrar uma mensagem de sucesso
            $message = "Se o email existir em nossa base de dados, você receberá um link para redefinir sua senha.";
        } else {
            $error = "Ocorreu um erro. Por favor, tente novamente.";
        }
    } else {
        // Por segurança, mostramos a mesma mensagem mesmo se o email não existir
        $message = "Se o email existir em nossa base de dados, você receberá um link para redefinir sua senha.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Team Flávio Santos</title>
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
      <h2>Recuperar Senha</h2>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <?php if ($message): ?>
      <div class="alert alert-success">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
        <small class="text-muted">Digite o email associado à sua conta.</small>
      </div>

      <button type="submit" class="btn btn-auth">Enviar Link de Recuperação</button>
    </form>

    <div class="auth-footer">
      <p>Lembrou sua senha? <a href="login.php">Voltar ao Login</a></p>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html> 