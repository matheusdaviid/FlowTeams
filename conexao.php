<?php
$host = '127.0.0.1';
$dbname = 'db_flowteams';
$username = 'root'; // substitua pelo seu usuário
$password = '';     // substitua pela sua senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}