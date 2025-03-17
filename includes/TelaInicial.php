<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowTeams</title>
    <link rel="stylesheet" href="../assets/css/TelaInicial.css">
    <link rel="stylesheet" href="../assets/css/carrossel.css">
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
        <!-- Componente branco que agrupa o carrossel e a seção de designs recentes -->
        <div class="content-wrapper">
            <!-- Ícones de perfil, notificação e configuração -->
            <div class="icons-container">
                <i class="bi bi-bell notification-icon"></i>
                <i class="bi bi-gear settings-icon" onclick="window.location.href='./Configuracoes.php#configuracoes'"></i>
                <i class="bi bi-person-circle profile-icon" onclick="window.location.href='./Configuracoes.php#perfil'"></i>
            </div>

            <!-- Carrossel de boas-vindas -->
            <div class="welcome-carousel">
                <img src="../assets/img/Carrossel.png" alt="Carrossel" class="carousel-image">
                <h1>BEM VINDO AO <span class="underline">FLOWTEAMS</span></h1>
            </div>

            <!-- Seção de designs recentes -->
            <section class="recent-designs">
                <h2>Projetos recentes</h2>
                <!-- Conteúdo dos projetos recentes -->
            </section>
        </div>
    </div>

    <script src="../javaScript/sidebar.js"></script>
    <script src="../javaScript/"></script>
</body>

</html>