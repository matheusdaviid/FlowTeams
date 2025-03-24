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

    // Verificar se e-mail já existe
    $stmt = $pdo->prepare("SELECT id FROM tb_cadastro WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'E-mail já cadastrado']);
        exit;
    }

    // Inserir novo usuário (senha SEM CRIPTOGRAFIA)
    $stmt = $pdo->prepare("INSERT INTO tb_cadastro (email, senha) VALUES (:email, :senha)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();

    // Iniciar sessão
    session_start();
    $_SESSION['usuario_id'] = $pdo->lastInsertId();
    $_SESSION['usuario_email'] = $email;
    $_SESSION['logado'] = true;

    echo json_encode(['success' => true, 'message' => 'Cadastro realizado!']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar']);
}
?>