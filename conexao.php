<?php
// Define o endereço do servidor do banco de dados (localhost = computador local)
$host = '127.0.0.1';

// Nome do banco de dados que você criou (no caso, "db_flowteams")
$dbname = 'db_flowteams';

// Nome do usuário do banco de dados (padrão do XAMPP é "root")
$username = 'root';

// Senha do banco (por padrão, no XAMPP, é vazia)
$password = '';

try {
    // Cria a conexão com o banco usando PDO (uma forma segura e moderna de conectar com bancos)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Define o modo de erro do PDO pra lançar exceções, facilitando o tratamento de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Se der erro na conexão, exibe a mensagem
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
