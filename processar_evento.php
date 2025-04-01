<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: TelaLogin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$nome_evento = $_POST['nome_evento'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$horario = $_POST['horario'] ?? '';
$prioridade = $_POST['prioridade'] ?? 'Média';
$data_evento = $_POST['data_evento'] ?? '';

if (empty($nome_evento) || empty($horario) || empty($data_evento)) {
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO tb_eventos (id_usuario, nome_evento, descricao_evento, horario, prioridade, data_evento) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$usuario_id, $nome_evento, $descricao, $horario, $prioridade, $data_evento]);
    
    echo json_encode(['success' => true, 'message' => 'Evento salvo com sucesso!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar evento: ' . $e->getMessage()]);
}
?>