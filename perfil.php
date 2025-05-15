<?php
session_start();
include 'header.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

require_once 'conexao.php';

// Busca dados do usuário primeiro
$sql = "SELECT * FROM users WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_user']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['id_user'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    // Processamento da imagem
    if (isset($_FILES['imagem_user']) && $_FILES['imagem_user']['error'] == 0) {
        $targetDir = "src/imgs/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        $safeImageName = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', basename($_FILES['imagem_user']['name']));
        $targetFile = $targetDir . $safeImageName;

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedImageTypes = ['jpg', 'png', 'jpeg', 'gif'];

        if (in_array($imageFileType, $allowedImageTypes)) {
            if (move_uploaded_file($_FILES['imagem_user']['tmp_name'], $targetFile)) {
                // Remove a imagem antiga se não for a padrão
                if (isset($user['imagem_user']) && $user['imagem_user'] != 'default_profile.png' && file_exists($targetDir . $user['imagem_user'])) {
                    unlink($targetDir . $user['imagem_user']);
                }

                $sql = "UPDATE users SET username = ?, email = ?, imagem_user = ? WHERE id_user = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $username, $email, $safeImageName, $id);
                
                if ($stmt->execute()) {
                    $_SESSION['username'] = $username;
                    $_SESSION['imagem_user'] = $safeImageName;
                    $success = "Perfil atualizado com sucesso!";
                    
                    // Atualiza os dados do usuário após a atualização
                    $sql = "SELECT * FROM users WHERE id_user = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $_SESSION['id_user']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();
                } else {
                    $error = "Erro ao atualizar o perfil: " . $stmt->error;
                }
            } else {
                $error = "Erro ao fazer upload da imagem.";
            }
        } else {
            $error = "Somente arquivos de imagem (JPG, JPEG, PNG, GIF) são permitidos.";
        }
    } else {
        // Atualiza apenas username e email
        $sql = "UPDATE users SET username = ?, email = ? WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $email, $id);
        
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $success = "Perfil atualizado com sucesso!";
            
            // Atualiza os dados do usuário após a atualização
            $sql = "SELECT * FROM users WHERE id_user = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION['id_user']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        } else {
            $error = "Erro ao atualizar o perfil: " . $stmt->error;
        }
    }
}
?>

<main class="profile-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-card">
                    <div class="profile-header">
                        <h2><i class="fas fa-user-circle me-2"></i>Meu Perfil</h2>
                    </div>
                    <div class="profile-body">
                        <?php if (isset($error)): ?>
                            <div class="profile-alert profile-alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($success)): ?>
                            <div class="profile-alert profile-alert-success" role="alert">
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="text-center mb-4">
                                <div class="profile-image-container">
                                    <img src="src/imgs/<?php echo isset($user['imagem_user']) ? $user['imagem_user'] : 'default_profile.png'; ?>" 
                                         alt="Foto de Perfil" 
                                         class="profile-image">
                                    <div class="profile-image-overlay">
                                        <label for="imagem_user" class="profile-image-upload">
                                            <i class="fas fa-camera"></i>
                                        </label>
                                    </div>
                                </div>
                                <input type="file" id="imagem_user" name="imagem_user" 
                                       class="d-none" accept="image/*">
                                <p class="profile-upload-hint">Clique na imagem para alterar</p>
                            </div>
                            
                            <div class="profile-form-group">
                                <label for="username" class="profile-form-label">
                                    <i class="fas fa-user me-2"></i>Nome de Usuário
                                </label>
                                <input type="text" class="profile-form-control" id="username" name="username" 
                                       value="<?php echo isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?>" required>
                            </div>
                            
                            <div class="profile-form-group">
                                <label for="email" class="profile-form-label">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <input type="email" class="profile-form-control" id="email" name="email" 
                                       value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" required>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="index.php" class="profile-btn profile-btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                                <button type="submit" class="profile-btn profile-btn-primary">
                                    <i class="fas fa-save me-2"></i>Salvar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileImage = document.querySelector('.profile-image');
    const fileInput = document.getElementById('imagem_user');
    
    profileImage.addEventListener('click', function() {
        fileInput.click();
    });
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>

<?php include 'footer.php'; ?> 