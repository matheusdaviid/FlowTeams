<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: TelaLogin.php');
    exit;
}

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

// Obtém o ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];

// Recebe os dados do formulário
$projectId = $_POST['projectId'] ?? '';
$titulo = $_POST['projectTitle'] ?? '';
$data_inicio = $_POST['startDate'] ?? '';
$data_termino = $_POST['endDate'] ?? '';
$descricao = $_POST['projectDescription'] ?? '';

// Validação dos campos obrigatórios
if (empty($titulo) || empty($data_inicio) || empty($data_termino)) {
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios']);
    exit;
}

// Validação das datas
if (strtotime($data_inicio) > strtotime($data_termino)) {
    echo json_encode(['success' => false, 'message' => 'A data de término deve ser posterior à data de início']);
    exit;
}

try {
    if (empty($projectId)) {
        // Inserir novo projeto
        $stmt = $pdo->prepare("INSERT INTO tb_projetos (titulo, data_inicio, data_termino, descricao, usuario_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $data_inicio, $data_termino, $descricao, $usuario_id]);
        $message = 'Projeto cadastrado com sucesso!';
    } else {
        // Atualizar projeto existente (verificando se pertence ao usuário)
        $stmt = $pdo->prepare("UPDATE tb_projetos SET titulo = ?, data_inicio = ?, data_termino = ?, descricao = ? WHERE id = ? AND usuario_id = ?");
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