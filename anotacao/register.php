<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    $errors = [];
    
    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "Todos os campos são obrigatórios";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "As senhas não coincidem";
    }
    
    if (strlen($password) < 6) {
        $errors[] = "Senha deve ter pelo menos 6 caracteres";
    }
    
    if (empty($errors)) {
        if (registerUser($username, $email, $password)) {
            $_SESSION['success'] = "Registro bem-sucedido! Por favor, faça login.";
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Nome de usuário ou email já existe";
        }
    }
}

if (isLoggedIn()) {
    header("Location: notes/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - NoteTaking</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h2><i class="fas fa-user-plus"></i> cadastre-se</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Nome de usuário</label>
                    <input type="text" id="username" name="username" required 
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirme sua senha</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Registre</button>
            </form>

            <p class="auth-link">
                Já tem uma conta? <a href="login.php">Entre por aqui</a>
            </p>
        </div>
    </div>
</body>
</html>