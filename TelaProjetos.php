<?php
// Inicia a sessão para armazenar dados do usuário durante a navegação
session_start();

// Inclui o arquivo que faz a conexão com o banco de dados
require_once 'conexao.php';

// Verifica se o usuário está logado, se não estiver, redireciona para login
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: TelaLogin.php');
    exit; // Encerra a execução do script
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade -->
    <title>FlowTeams - Projetos</title> <!-- Título da página -->
    
    <!-- Links para arquivos de estilo -->
    <link rel="stylesheet" href="./assets/css/TelaProjetos.css"> <!-- Estilo principal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- Ícones -->
</head>

<body>
    <!-- Barra lateral de navegação -->
    <div class="sidebar">
        <!-- Cabeçalho com logo -->
        <div class="logo_content">
            <img src="./assets/img/logo-flowteams.png" alt="Logo FlowTeams" class="logo">
            <span class="logo_name">FlowTeams</span> <!-- Nome do sistema -->
        </div>

        <!-- Menu de navegação -->
        <div class="menu">
            <!-- Botão para a página inicial -->
            <button onclick="window.location.href='./Telainicial.php'">
                <i class="bi bi-house"></i> <!-- Ícone de casa -->
                <span class="menu_text">Início</span>
            </button>
            
            <!-- Botão para projetos (página atual) -->
            <button onclick="window.location.href='./TelaProjetos.php'">
                <i class="bi bi-kanban"></i> <!-- Ícone de kanban -->
                <span class="menu_text">Projetos</span>
            </button>
            
            <!-- Botão para calendário -->
            <button onclick="window.location.href='./TelaCalendario.php'">
                <i class="bi bi-calendar2-date"></i> <!-- Ícone de calendário -->
                <span class="menu_text">Calendário</span>
            </button>
        </div>
    </div>

    <!-- Conteúdo principal da página -->
    <div class="main-content">
        <!-- Container do formulário -->
        <div class="content-wrapper">
            <h1>Cadastrar Projeto</h1>
            
            <!-- Formulário para cadastrar/editar projetos -->
            <form id="projectForm" action="processar_projeto.php" method="POST">
                <!-- Campo oculto para ID do projeto (usado em edições) -->
                <input type="hidden" id="projectId" name="projectId" value="">
                
                <!-- Grupo de campo: Título do projeto -->
                <div class="form-group">
                    <label for="projectTitle">Título:</label>
                    <input type="text" id="projectTitle" name="projectTitle" placeholder="Digite aqui o nome do projeto" required>
                </div>
                
                <!-- Grupo de campo: Data de início -->
                <div class="form-group">
                    <label for="startDate">Início:</label>
                    <input type="date" id="startDate" name="startDate" required>
                </div>
                
                <!-- Grupo de campo: Data de término -->
                <div class="form-group">
                    <label for="endDate">Término:</label>
                    <input type="date" id="endDate" name="endDate" required>
                </div>
                
                <!-- Grupo de campo: Descrição -->
                <div class="form-group">
                    <label for="projectDescription">Descrição:</label>
                    <textarea id="projectDescription" name="projectDescription" placeholder="Digite aqui informações sobre o projeto" rows="4" required></textarea>
                </div>
                
                <!-- Botões de ação -->
                <div class="form-actions">
                    <button type="submit" class="btn-save">Salvar</button> <!-- Envia o formulário -->
                    <button type="button" class="btn-alterar">Alterar</button> <!-- Para edição -->
                    <button type="button" class="btn-excluir" style="display: none;">Excluir</button> <!-- Oculto inicialmente -->
                </div>
            </form>

            <!-- Seção que mostra os projetos cadastrados -->
            <div class="projects-container" id="projectsContainer">
                <h2>Projetos Cadastrados</h2>
                <div class="projects-grid">
                    <?php
                    try {
                        // Prepara e executa consulta para buscar projetos do usuário atual
                        $stmt = $pdo->prepare("SELECT * FROM tb_projetos WHERE id_usuario = ? ORDER BY data_inicio DESC");
                        $stmt->execute([$_SESSION['usuario_id']]);
                        
                        // Verifica se encontrou resultados
                        if ($stmt->rowCount() > 0) {
                            // Loop para exibir cada projeto
                            while ($projeto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '
                                <div class="project-card" data-id="'.$projeto['id'].'">
                                    <div class="project-thumbnail">'.substr($projeto['titulo'], 0, 1).'</div> <!-- Mostra a primeira letra do título -->
                                    <h3>'.$projeto['titulo'].'</h3> <!-- Título do projeto -->
                                    <div class="project-meta">
                                        <span><i class="bi bi-calendar"></i> '.date('d/m/Y', strtotime($projeto['data_inicio'])).'</span> <!-- Data início formatada -->
                                        <span><i class="bi bi-calendar-check"></i> '.date('d/m/Y', strtotime($projeto['data_termino'])).'</span> <!-- Data término formatada -->
                                    </div>
                                    <p class="project-description">'.$projeto['descricao'].'</p> <!-- Descrição do projeto -->
                                </div>';
                            }
                        } else {
                            // Mensagem quando não há projetos
                            echo '<div class="no-projects">
                                <i class="bi bi-info-circle"></i>
                                <p>Nenhum projeto cadastrado ainda</p>
                            </div>';
                        }
                    } catch (PDOException $e) {
                        // Mensagem de erro se a consulta falhar
                        echo '<div class="error-message">
                            <i class="bi bi-exclamation-triangle"></i>
                            <p>Erro ao carregar projetos</p>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts JavaScript -->
    <script src="./javaScript/sidebar.js"></script> <!-- Controle da barra lateral -->
    <script src="./javaScript/TelaProjetos.js"></script> <!-- Lógica da tela de projetos -->

    <!-- Popup de sucesso (hidden por padrão) -->
    <div id="successPopup" class="popup">
        <span id="successMessage"></span> <!-- Mensagem dinâmica -->
    </div>
</body>
</html>