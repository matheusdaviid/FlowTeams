<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit;
}

// Configurações do banco de dados
$host = '127.0.0.1';
$dbname = 'db_flowteams';
$username = 'root'; // substitua pelo seu usuário
$password = '';     // substitua pela sua senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $novoEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $usuarioId = $_SESSION['usuario_id'];

    if (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'E-mail inválido']);
        exit;
    }

    // Verifica se o email já existe
    $stmt = $pdo->prepare("SELECT id FROM tb_cadastro WHERE email = :email AND id != :id");
    $stmt->bindParam(':email', $novoEmail);
    $stmt->bindParam(':id', $usuarioId);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Este e-mail já está em uso']);
        exit;
    }

    // Atualiza no banco de dados
    $stmt = $pdo->prepare("UPDATE tb_cadastro SET email = :email WHERE id = :id");
    $stmt->bindParam(':email', $novoEmail);
    $stmt->bindParam(':id', $usuarioId);
    $stmt->execute();

    // Atualiza na sessão
    $_SESSION['usuario_email'] = $novoEmail;

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    error_log("Erro ao atualizar email: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erro no servidor']);
}