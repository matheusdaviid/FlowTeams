<?php
require 'config.php'; // Inclui o arquivo de configuração do banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Busca o usuário no banco de dados
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        echo "Login bem-sucedido!";
        // Inicia a sessão e redireciona o usuário
        session_start();
        $_SESSION['user_email'] = $user['email'];
        header('Location: TelaInicial.php');
        exit();
    } else {
        echo "E-mail ou senha incorretos.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>