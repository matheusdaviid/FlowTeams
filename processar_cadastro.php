<?php
header('Content-Type: application/json');
require_once 'conexao.php';

try {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['password'] ?? '';

    if (empty($email) || empty($senha)) {
        echo json_encode(['success' => false, 'message' => 'Preencha todos os campos']);
        exit;
    }

   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'E-mail inválido']);
        exit;
    }

    
    if (strlen($senha) < 8) {
        echo json_encode(['success' => false, 'message' => 'A senha deve ter pelo menos 8 caracteres']);
        exit;
    }

    if (!preg_match('/[A-Z]/', $senha)) {
        echo json_encode(['success' => false, 'message' => 'A senha deve conter pelo menos uma letra maiúscula']);
        exit;
    }

    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $senha)) {
        echo json_encode(['success' => false, 'message' => 'A senha deve conter pelo menos um símbolo']);
        exit;
    }

    
    $stmt = $pdo->prepare("SELECT id FROM tb_cadastro WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'E-mail já cadastrado']);
        exit;
    }

    
    $stmt = $pdo->prepare("INSERT INTO tb_cadastro (email, senha) VALUES (?, ?)");
    $stmt->execute([$email, $senha]);

   
    session_start();
    $_SESSION['usuario_id'] = $pdo->lastInsertId();
    $_SESSION['usuario_email'] = $email;
    $_SESSION['logado'] = true;

    echo json_encode(['success' => true, 'redirect' => 'Telainicial.php']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar']);
}
?>