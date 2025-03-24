<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowTeams - Projetos</title>
    <link rel="stylesheet" href="../assets/css/TelaProjetos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Menu lateral esquerdo -->
    <div class="sidebar">
        <!-- Nome do site -->
        <div class="logo_content">
            <img src="../assets/img/logo-flowteams.png" alt="Logo FlowTeams" class="logo">
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
                    <!-- Projetos serão adicionados dinamicamente aqui -->
                </div>
            </section>
        </div>
    </div>

    <script src="../javaScript/sidebar.js"></script>
    <link rel="stylesheet" href="../assets/css/TelaProjetos.css">
    <script src="../javaScript/TelaProjetos.js"></script>

    <!-- Pop-ups de sucesso -->
    <div id="successPopup" class="popup">
        <span id="successMessage"></span>
    </div>
</body>

</html>