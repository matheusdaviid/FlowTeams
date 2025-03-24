<?php
header('Content-Type: application/json');

// Configurações do banco
$host = '127.0.0.1';
$dbname = 'db_flowteams';
$username = 'root'; // substitua pelo seu usuário
$password = '';     // substitua pela sua senha

try {
    // Conexão com o banco
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Receber dados
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['password'] ?? '';

    // Validações
    if (empty($email) || empty($senha)) {
        echo json_encode(['success' => false, 'message' => 'Preencha todos os campos']);
        exit;
    }

    // Buscar usuário
    $stmt = $pdo->prepare("SELECT id, email, senha FROM tb_cadastro WHERE email = :email AND senha = :senha");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();
    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo json_encode(['success' => false, 'message' => 'E-mail ou senha incorretos']);
        exit;
    }

    // Login bem-sucedido
    session_start();
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_email'] = $usuario['email'];
    $_SESSION['logado'] = true;

    echo json_encode(['success' => true, 'message' => 'Login realizado!']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no servidor']);
}
?>