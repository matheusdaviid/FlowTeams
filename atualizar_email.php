<?php
// Inicia a sessão — isso permite acessar variáveis salvas na sessão do usuário (como o ID dele)
session_start();

// Diz que a resposta será em formato JSON
header('Content-Type: application/json');

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Se não estiver logado, responde com erro
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit; // Para o código aqui
}

// Conecta com o banco de dados (puxando o arquivo que tem os dados de conexão)
require 'conexao.php';

try {
    // Pega o novo e-mail enviado pelo formulário e filtra pra garantir que seja seguro
    $novoEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    // Pega o ID do usuário da sessão (quem está logado)
    $usuarioId = $_SESSION['usuario_id'];

    // Verifica se o e-mail é mesmo válido
    if (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, insira um e-mail válido (exemplo@dominio.com)']);
        exit;
    }

    // Verifica no banco se já existe esse e-mail cadastrado, e se não é o do próprio usuário
    $stmt = $pdo->prepare("SELECT id FROM tb_cadastro WHERE email = :email AND id != :id");
    $stmt->bindParam(':email', $novoEmail);
    $stmt->bindParam(':id', $usuarioId);
    $stmt->execute();

    // Se encontrar algum resultado, significa que o e-mail já está em uso
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Este e-mail já está em uso']);
        exit;
    }

    // Se passou na verificação, atualiza o e-mail no banco
    $stmt = $pdo->prepare("UPDATE tb_cadastro SET email = :email WHERE id = :id");
    $stmt->bindParam(':email', $novoEmail);
    $stmt->bindParam(':id', $usuarioId);
    $stmt->execute();

    // Atualiza o e-mail também na sessão
    $_SESSION['usuario_email'] = $novoEmail;

    // Retorna resposta de sucesso
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    // Se der erro, registra no log do servidor
    error_log("Erro ao atualizar email: " . $e->getMessage());
    // E responde com erro genérico pro usuário
    echo json_encode(['success' => false, 'message' => 'Erro no servidor']);
}
?>
