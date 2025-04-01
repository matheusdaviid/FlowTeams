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

    $stmt = $pdo->prepare("SELECT id, email, senha FROM tb_cadastro WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario || $senha !== $usuario['senha']) {
        echo json_encode(['success' => false, 'message' => 'E-mail ou senha incorretos']);
        exit;
    }

    session_start();
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_email'] = $usuario['email'];
    $_SESSION['logado'] = true;

    echo json_encode(['success' => true, 'redirect' => 'Telainicial.php']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no servidor']);
}
?>