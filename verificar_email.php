<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'conexao.php';

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: esqueceu_senha.php?erro=Por favor, informe um e-mail válido");
    exit;
}

// Verifica se o e-mail existe
$stmt = $pdo->prepare("SELECT id FROM tb_cadastro WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    // E-mail existe - gerar token
    $token = bin2hex(random_bytes(32));
    $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    // Salvar token no banco
    $stmt = $pdo->prepare("UPDATE tb_cadastro SET token_reset = ?, token_expira = ? WHERE email = ?");
    if ($stmt->execute([$token, $expira, $email])) {
        // Enviar e-mail com o link 
        $link = "http://".$_SERVER['HTTP_HOST']."/esqueceu_senha.php?token=$token";
        
      
        $_SESSION['email_simulado'] = "Link de redefinição: $link";
        
        header("Location: esqueceu_senha.php?token=$token");
        exit;
    } else {
        header("Location: esqueceu_senha.php?erro=Erro ao gerar link de redefinição");
        exit;
    }
} else {
    // E-mail não existe
    header("Location: esqueceu_senha.php?erro=E-mail não cadastrado em nosso sistema");
    exit;
}