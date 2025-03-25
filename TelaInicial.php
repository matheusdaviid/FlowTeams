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
    <title>FlowTeams - Início</title>
    <link rel="stylesheet" href="./assets/css/Telainicial.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Menu lateral esquerdo -->
    <div class="sidebar">
        <div class="logo_content">
            <img src="./assets/img/logo-flowteams.png" alt="Logo FlowTeams" class="logo">
            <span class="logo_name">FlowTeams</span>
        </div>

        <div class="search-bar-container">
            <div class="search-icon-container">
                <i class="bi bi-search search-icon"></i>
            </div>
            <input type="text" placeholder="Pesquise aqui" class="search-bar">
        </div>

        <div class="menu">
            <button onclick="window.location.href='./Telainicial.php'" class="active">
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
        <!-- Cabeçalho com barra de busca e ícones -->
        <div class="header">
            <div class="header-content">
                <div class="welcome-message">
                    Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome_usuario'] ?? 'Usuário'); ?>!
                </div>
                <div class="user-actions">
                    <a href="Configuracoes.php"><i class="bi bi-gear-fill config-icon"></i></a>
                    <a href="Configuracoes.php"><i class="bi bi-person-fill profile-icon"></i></a>
                </div>
            </div>
        </div>

        <!-- Conteúdo principal -->
        <div class="content-wrapper">
            <!-- Seção de boas-vindas -->
            <div class="welcome-section">
                <h1>Dashboard</h1>
                <p>Acompanhe suas atividades e projetos recentes</p>
            </div>

            <!-- Seção de projetos recentes -->
            <div class="section-projects">
                <div class="section-header">
                    <h2>Projetos Recentes</h2>
                    <a href="TelaProjetos.php" class="view-all">Ver todos</a>
                </div>
                
                <div class="projects-grid">
                    <?php
                    try {
                        $stmt = $pdo->prepare("SELECT * FROM tb_projetos WHERE usuario_id = ? ORDER BY data_inicio DESC LIMIT 3");
                        $stmt->execute([$_SESSION['usuario_id']]);
                        
                        if ($stmt->rowCount() > 0) {
                            while ($projeto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '
                                <div class="project-card">
                                    <div class="project-thumbnail"></div>
                                    <h3>'.$projeto['titulo'].'</h3>
                                    <div class="project-meta">
                                        <span><i class="bi bi-calendar"></i> '.date('d/m/Y', strtotime($projeto['data_inicio'])).'</span>
                                    </div>
                                    <p class="project-description">'.substr($projeto['descricao'], 0, 80).'...</p>
                                    <a href="TelaProjetos.php" class="btn-ver-projeto"><i class="bi bi-arrow-right"></i> Ver projeto</a>
                                </div>';
                            }
                        } else {
                            echo '<div class="no-projects">
                                <p>Nenhum projeto encontrado</p>
                                <a href="TelaProjetos.php" class="btn-new-project"><i class="bi bi-plus-lg"></i> Criar projeto</a>
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
            </div>
        </div>
    </div>

    <script src="./javaScript/sidebar.js"></script>
</body>
</html>                   