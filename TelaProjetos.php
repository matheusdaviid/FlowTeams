<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: TelaLogin.php');
    exit;
}

// Conexão com o banco de dados
require_once 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowTeams - Projetos</title>
    <link rel="stylesheet" href="./assets/css/TelaProjetos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Menu lateral esquerdo -->
    <div class="sidebar">
        <!-- Nome do site -->
        <div class="logo_content">
            <img src="./assets/img/logo-flowteams.png" alt="Logo FlowTeams" class="logo">
            <span class="logo_name">FlowTeams</span>
        </div>

        <!-- Barra de busca dentro do sidebar -->
        <div class="search-bar-container">
            <div class="search-icon-container">
                <i class="bi bi-search search-icon"></i>
            </div>
            <input type="text" placeholder="Pesquise aqui" class="search-bar">
        </div>

        <!-- Menu com opções de navegação dispostas verticalmente -->
        <div class="menu">
            <button onclick="window.location.href='./Telainicial.php'">
                <i class="bi bi-house"></i>
                <span class="menu_text">Início</span>
            </button>
            <button onclick="window.location.href='./TelaProjetos.php'">
                <i class="bi bi-kanban"></i>
                <span class="menu_text">Projetos</span>
            </button>
            <button onclick="window.location.href='./TelaCalendario.php'">
                <i class="bi bi-calendar2-date"></i>
                <span class="menu_text">Calendário</span>
            </button>
        </div>
    </div>

    <!-- Conteúdo principal do site -->
    <div class="main-content">
        <!-- Componente branco que agrupa o formulário de cadastro de projetos -->
        <div class="content-wrapper">
            <h1>Cadastrar Projeto</h1>
            <form id="projectForm" action="processar_projeto.php" method="POST">
                <input type="hidden" id="projectId" name="projectId" value="">
                <div class="form-group">
                    <label for="projectTitle">Título:</label>
                    <input type="text" id="projectTitle" name="projectTitle" placeholder="Digite aqui o nome do projeto" required>
                </div>
                <div class="form-group">
                    <label for="startDate">Início:</label>
                    <input type="date" id="startDate" name="startDate" required>
                </div>
                <div class="form-group">
                    <label for="endDate">Término:</label>
                    <input type="date" id="endDate" name="endDate" required>
                </div>
                <div class="form-group">
                    <label for="projectDescription">Descrição:</label>
                    <textarea id="projectDescription" name="projectDescription" placeholder="Digite aqui informações sobre o projeto" rows="4" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save">Salvar</button>
                    <button type="button" class="btn-alterar">Alterar</button>
                    <button type="button" class="btn-excluir" style="display: none;">Excluir</button>
                </div>
            </form>

            <!-- Seção de projetos cadastrados -->
            <section class="recent-projects">
                <h2>Projetos Cadastrados</h2>
                <div class="projects-grid" id="projectsGrid">
                    <?php
                    try {
                        $stmt = $pdo->prepare("SELECT * FROM tb_projetos WHERE usuario_id = ? ORDER BY data_inicio DESC");
                        $stmt->execute([$_SESSION['usuario_id']]);
                        while ($projeto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '
                            <div class="project-card" data-id="'.$projeto['id'].'">
                                <div class="project-thumbnail">'.substr($projeto['titulo'], 0, 1).'</div>
                                <h3>'.$projeto['titulo'].'</h3>
                                <div class="project-meta">
                                    <span><i class="bi bi-calendar"></i> '.date('d/m/Y', strtotime($projeto['data_inicio'])).'</span>
                                    <span><i class="bi bi-calendar-check"></i> '.date('d/m/Y', strtotime($projeto['data_termino'])).'</span>
                                </div>
                                <p class="project-description">'.$projeto['descricao'].'</p>
                            </div>';
                        }
                    } catch (PDOException $e) {
                        echo '<div class="error-message">
                            <i class="bi bi-exclamation-triangle"></i>
                            <p>Erro ao carregar projetos</p>
                        </div>';
                    }
                    ?>
                </div>
            </section>
        </div>
    </div>

    <script src="./javaScript/sidebar.js"></script>
    <script src="./javaScript/TelaProjetos.js"></script>

    <!-- Pop-ups de sucesso -->
    <div id="successPopup" class="popup">
        <span id="successMessage"></span>
    </div>
</body>
</html>