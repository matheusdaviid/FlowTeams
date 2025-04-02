<?php
session_start();
require 'conexao.php';

class RedefinirSenha {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function validarToken($token) {
        $stmt = $this->pdo->prepare("SELECT email FROM tb_cadastro WHERE token_reset = ? AND token_expira > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function atualizarSenha($email, $novaSenha) {
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE tb_cadastro SET senha = ?, token_reset = NULL, token_expira = NULL WHERE email = ?");
        return $stmt->execute([$senhaHash, $email]);
    }
}

$token = $_GET['token'] ?? '';
$mensagem = '';
$erro = '';

$redefinirSenha = new RedefinirSenha($pdo);

// Verifica se o token é válido
$dadosUsuario = $redefinirSenha->validarToken($token);

if (!$dadosUsuario) {
    header("Location: esqueceu_senha.php?erro=Token inválido ou expirado");
    exit;
}

// Processa o formulário de nova senha
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaSenha = $_POST['nova_senha'];
    $confirmarSenha = $_POST['confirmar_senha'];
    
    // Validações
    if (empty($novaSenha)) {
        $erro = "Por favor, informe a nova senha.";
    } elseif (strlen($novaSenha) < 8) {
        $erro = "A senha deve ter pelo menos 8 caracteres.";
    } elseif (!preg_match('/[A-Z]/', $novaSenha)) {
        $erro = "A senha deve conter pelo menos uma letra maiúscula.";
    } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $novaSenha)) {
        $erro = "A senha deve conter pelo menos um símbolo.";
    } elseif ($novaSenha !== $confirmarSenha) {
        $erro = "As senhas não coincidem.";
    } else {
        // Atualiza a senha
        if ($redefinirSenha->atualizarSenha($dadosUsuario['email'], $novaSenha)) {
            $mensagem = "Senha redefinida com sucesso!";
            header("Refresh: 3; url=TelaLogin.php");
        } else {
            $erro = "Erro ao redefinir a senha. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/esqueceu_senha.css">
    <title>Nova Senha - FlowTeams</title>
</head>
<body>
    <div class="logo-container">
        <img src="./assets/img/logo-flowteams.png" alt="Logo FlowTeams">
    </div>

    <div class="container">
        <div class="form-container">
            <form id="novaSenhaForm" method="POST">
                <h1>Crie uma Nova Senha</h1>
                
                <?php if ($mensagem): ?>
                    <div class="alert success"><?= $mensagem ?></div>
                <?php elseif ($erro): ?>
                    <div class="alert error"><?= $erro ?></div>
                <?php endif; ?>
                
                <div class="input-group">
                    <input type="password" id="nova_senha" name="nova_senha" placeholder="Nova senha" required>
                    <i class="fas fa-lock"></i>
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
                    <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme a nova senha" required>
                    <i class="fas fa-lock"></i>
                </div>
                
                <button type="submit">Redefinir Senha</button>
                <a href="TelaLogin.php" class="back-link">Voltar ao Login</a>
            </form>
        </div>
    </div>

    <script src="./assets/js/redefinir_senha.js"></script>
</body>
</html>