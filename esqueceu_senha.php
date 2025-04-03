<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'conexao.php';

// Verifica se há um token na URL (fase 2)
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

// Se tiver token, verifica se é válido
if ($token) {
    $stmt = $pdo->prepare("SELECT email FROM tb_cadastro WHERE token_reset = ? AND token_expira > NOW()");
    $stmt->execute([$token]);
    $usuario = $stmt->fetch();
    
    if (!$usuario) {
        header("Location: esqueceu_senha.php?erro=Token inválido ou expirado");
        exit;
    }
    $email = $usuario['email'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/esqueceu_senha.css">
    <title>Redefinir Senha - FlowTeams</title>
</head>
<body>
    <div class="logo-container">
        <img src="./assets/img/logo-flowteams.png" alt="Logo FlowTeams">
    </div>

    <div class="container">
        <?php if (empty($token)): ?>
            <!-- Fase 1: Solicitar e-mail -->
            <div class="form-container" id="emailForm">
                <form id="resetForm" method="POST" action="verificar_email.php" autocomplete="on">
                    <h1>Redefinir Senha</h1>
                    <span>Digite seu e-mail cadastrado para verificação</span>
                    
                    <?php if (isset($_GET['erro'])): ?>
                        <div class="alert error"><?= htmlspecialchars($_GET['erro']) ?></div>
                    <?php endif; ?>
                    
                    <div id="message" class="alert" style="display: none;"></div>
                    
                    <div class="input-group">
                        <input type="email" id="email" name="email" placeholder="E-mail" required
                               autocomplete="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                    </div>
                    
                    <button type="submit">Verificar E-mail</button>
                    <a href="TelaLogin.php" class="back-link">Voltar ao Login</a>
                </form>
            </div>
        <?php else: ?>
            <!-- Fase 2: Redefinir senha -->
            <div class="form-container" id="passwordForm">
                <form id="novaSenhaForm" method="POST" action="processar_redefinicao.php" autocomplete="on">
                    <h1>Redefinir Senha</h1>
                    <div class="email-verified">
                        <i class="fas fa-check-circle"></i>
                        <span>E-mail verificado: <?= htmlspecialchars($email) ?></span>
                    </div>
                    
                    <div id="message" class="alert" style="display: none;"></div>
                    
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    
                    <div class="input-group">
                        <input type="password" id="nova_senha" name="nova_senha" placeholder="Nova senha" required
                               autocomplete="new-password">
                        <div class="password-requirements">
                            <span>A senha deve conter:</span>
                            <ul>
                                <li id="req-length">Pelo menos 8 caracteres</li>
                                <li id="req-uppercase">Uma letra maiúscula</li>
                                <li id="req-symbol">Um símbolo especial</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <input type="password" id="confirmar_senha" name="confirmar_senha" 
                               placeholder="Confirme a nova senha" required
                               autocomplete="new-password">
                    </div>
                    
                    <button type="submit">Redefinir Senha</button>
                    <a href="TelaLogin.php" class="back-link">Voltar ao Login</a>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script src="/assets/js/esqueceu_senha.js"></script>
</body>
</html>