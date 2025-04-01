<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['logado'])) {
    header('Location: TelaLogin.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$projectId = $_POST['id'] ?? '';

if (empty($projectId)) {
    echo json_encode(['success' => false, 'message' => 'ID do projeto não fornecido.']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM tb_projetos WHERE id = ? AND id_usuario = ?");
    $stmt->execute([$projectId, $usuario_id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Projeto excluído com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Projeto não encontrado ou você não tem permissão para excluí-lo.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao excluir projeto: ' . $e->getMessage()]);
}
?>