<?php
$host = '127.0.0.1'; // Host do MySQL
$db   = 'db_flowteams'; // Nome do banco de dados
$user = 'root'; // Usuário do MySQL (padrão do XAMPP)
$pass = ''; // Senha do MySQL (padrão do XAMPP é vazia)
$charset = 'utf8mb4'; // Codificação de caracteres

// Configuração do DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opções do PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorna os resultados como array associativo
    PDO::ATTR_EMULATE_PREPARES   => false, // Desativa a emulação de prepared statements
];

try {
    // Cria a conexão PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Em caso de erro, exibe uma mensagem e encerra o script
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>