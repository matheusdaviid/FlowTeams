<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'conexao.php';

$token = $_POST['token'] ?? '';
$novaSenha = $_POST['nova_senha'] ?? '';
$confirmarSenha = $_POST['confirmar_senha'] ?? '';

// Validar token
$stmt = $pdo->prepare("SELECT email FROM tb_cadastro WHERE token_reset = ? AND token_expira > NOW()");
$stmt->execute([$token]);
$usuario = $stmt->fetch();

if (!$usuario) {
    header("Location: esqueceu_senha.php?erro=Token inválido ou expirado");
    exit;
}

// Validar senha
if ($novaSenha !== $confirmarSenha) {
    header("Location: esqueceu_senha.php?token=$token&erro=As senhas não coincidem");
    exit;
}

if (strlen($novaSenha) < 8) {
    header("Location: esqueceu_senha.php?token=$token&erro=A senha deve ter pelo menos 8 caracteres");
    exit;
}

if (!preg_match('/[A-Z]/', $novaSenha)) {
    header("Location: esqueceu_senha.php?token=$token&erro=A senha deve conter uma letra maiúscula");
    exit;
}

if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $novaSenha)) {
    header("Location: esqueceu_senha.php?token=$token&erro=A senha deve conter um símbolo");
    exit;
}


$stmt = $pdo->prepare("UPDATE tb_cadastro SET senha = ?, token_reset = NULL, token_expira = NULL WHERE email = ?");

if ($stmt->execute([$novaSenha, $usuario['email']])) {
    header("Location: TelaLogin.php?sucesso=Senha redefinida com sucesso");
} else {
    header("Location: esqueceu_senha.php?token=$token&erro=Erro ao atualizar senha");
}
exit;