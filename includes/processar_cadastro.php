<?php
require 'config.php'; // Inclui o arquivo de configuração do banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptografa a senha

    // Verifica se o e-mail já está cadastrado
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        echo "E-mail já cadastrado.";
    } else {
        // Insere o novo usuário no banco de dados
        $stmt = $pdo->prepare('INSERT INTO usuarios (email, senha) VALUES (?, ?)');
        if ($stmt->execute([$email, $senha])) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário.";
        }
    }
} else {
    echo "Método de requisição inválido.";
}
?>