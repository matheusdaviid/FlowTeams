<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit;
}

require 'conexao.php';

try {
    $novoEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $usuarioId = $_SESSION['usuario_id'];

    if (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, insira um e-mail válido (exemplo@dominio.com)']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM tb_cadastro WHERE email = :email AND id != :id");
    $stmt->bindParam(':email', $novoEmail);
    $stmt->bindParam(':id', $usuarioId);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Este e-mail já está em uso']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE tb_cadastro SET email = :email WHERE id = :id");
    $stmt->bindParam(':email', $novoEmail);
    $stmt->bindParam(':id', $usuarioId);
    $stmt->execute();

    $_SESSION['usuario_email'] = $novoEmail;

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    error_log("Erro ao atualizar email: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erro no servidor']);
}
?>