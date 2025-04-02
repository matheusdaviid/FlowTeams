<?php
require 'conexao.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['exists' => false]);
        exit;
    }
    
    // Alterado para verificar na tabela tb_cadastro
    $stmt = $pdo->prepare("SELECT id FROM tb_cadastro WHERE email = ?");
    $stmt->execute([$email]);
    
    echo json_encode(['exists' => $stmt->fetch() !== false]);
}