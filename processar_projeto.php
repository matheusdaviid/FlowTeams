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
$projectId = $_POST['projectId'] ?? '';
$titulo = $_POST['projectTitle'] ?? '';
$data_inicio = $_POST['startDate'] ?? '';
$data_termino = $_POST['endDate'] ?? '';
$descricao = $_POST['projectDescription'] ?? '';

if (empty($titulo) || empty($data_inicio) || empty($data_termino)) {
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios']);
    exit;
}

if (strtotime($data_inicio) > strtotime($data_termino)) {
    echo json_encode(['success' => false, 'message' => 'A data de término deve ser posterior à data de início']);
    exit;
}

try {
    if (empty($projectId)) {
        $stmt = $pdo->prepare("INSERT INTO tb_projetos (titulo, data_inicio, data_termino, descricao, id_usuario) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $data_inicio, $data_termino, $descricao, $usuario_id]);
        $message = 'Projeto cadastrado com sucesso!';
    } else {
        $stmt = $pdo->prepare("UPDATE tb_projetos SET titulo = ?, data_inicio = ?, data_termino = ?, descricao = ? WHERE id = ? AND id_usuario = ?");
        $stmt->execute([$titulo, $data_inicio, $data_termino, $descricao, $projectId, $usuario_id]);
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'message' => 'Projeto não encontrado ou você não tem permissão para editá-lo']);
            exit;
        }
        
        $message = 'Projeto atualizado com sucesso!';
    }

    echo json_encode(['success' => true, 'message' => $message]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
?>