<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowTeams - Gerenciamento de Equipes</title>
    <link rel="stylesheet" href="./assets/css/TelaApresentacao.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Pré-carregar recursos críticos -->
    <link rel="preload" href="./assets/img/logo-flowteams.png" as="image">
    <link rel="preload" href="./assets/img/img-banner-flowteams.jpg" as="image">
</head>

<body>
    <!-- Cabeçalho -->
    <header class="cabecalho">
        <div class="logo">
            <!-- logo do site aqui -->
            <img src="./assets/img/logo-flowteams.png" alt="Logo FlowTeams">
            <span>FlowTeams</span>
        </div>
        <nav class="menu">
            <button class="btn-entrar" onclick="window.location.href='./TelaLogin.php'">Entrar</button>
            <button class="btn-inscrever" onclick="window.location.href='TelaLogin.php'">Inscrever-se</button>
        </nav>
    </header>

    <!-- Banner -->
    <section class="banner">
        <div class="banner-content">
            <h1>Gerencie sua equipe de forma eficiente</h1>
            <p>FlowTeams ajuda você a organizar projetos, tarefas e equipes em um só lugar.</p>
            <button class="btn-comecar" onclick="window.location.href='TelaLogin.php'">Comece agora</button>
        </div>
    </section>

    <!-- Cards de Funcionalidades -->
    <section class="cards" id="recursos">
        <h2>Recursos Principais</h2>
        <div class="card-container">
            <div class="card" onclick="window.location.href='TelaLogin.php'">
                <i class="fas fa-tasks"></i>
                <h3>Gestão de Tarefas</h3>
                <p>Organize e priorize tarefas de forma simples e intuitiva.</p>
            </div>
            <div class="card" onclick="window.location.href='TelaLogin.php'">
                <i class="fas fa-users"></i>
                <h3>Colaboração em Equipe</h3>
                <p>Facilite a comunicação e o trabalho em equipe.</p>
            </div>
            <div class="card" onclick="window.location.href='TelaLogin.php'">
                <i class="fas fa-chart-line"></i>
                <h3>Relatórios e Análises</h3>
                <p>Acompanhe o progresso com relatórios detalhados.</p>
            </div>
        </div>
    </section>

    <!-- Área do Banner e Texto -->
    <section class="banner-section">
        <div class="banner-section-content">
            <div class="banner-section-text">
                <h2>Conheça o FlowTeams</h2>
                <p>
                    O FlowTeams é a plataforma ideal para gerenciar suas equipes e projetos de forma colaborativa.
                    Com nossas ferramentas, você pode organizar tarefas, facilitar a comunicação e acompanhar o
                    progresso de seus projetos em tempo real. Conheça nossas funcionalidades e comece a transformar
                    a maneira como você trabalha em equipe.
                </p>
            </div>
            <div class="banner-section-image">
                <!-- imagem do banner aqui -->
                <img src="./assets/img/img-banner-flowteams.jpg" alt="Banner FlowTeams">
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="rodape">
        <div class="rodape-coluna">
            <h3>Ferramentas</h3>
            <a href="#top">Gestão de Tarefas</a>
            <a href="#top">Colaboração em Equipe</a>
            <a href="#top">Relatórios e Análises</a>
        </div>
        <div class="rodape-coluna">
            <h3>Baixar</h3>
            <a href="#top">Aplicativo para iOS</a>
            <a href="#top">Aplicativo para Android</a>
            <a href="#top">Versão para Desktop</a>
        </div>
        <div class="rodape-coluna">
            <h3>Explorar</h3>
            <a href="#top">Blog</a>
            <a href="#top">Recursos</a>
            <a href="#top">Planos</a>
        </div>
        <div class="rodape-coluna">
            <h3>FlowTeams</h3>
            <p>© 2025 FlowTeams. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="./javaScript/TelaApresentacao.js" defer></script>
</body>

</html>