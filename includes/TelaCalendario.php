<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowTeams - Calendário</title>
    <link rel="stylesheet" href="../assets/css/TelaCalendario.css">
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
        <!-- Componente branco que agrupa o calendário -->
        <div class="content-wrapper">
            <!-- Calendário -->
            <div class="calendar-container">
                <h1 class="calendar-title">Calendário</h1>
                <div class="calendar">
                    <div class="calendar-header">
                        <button id="prev-month" class="calendar-nav-button">&lt;</button>
                        <div class="calendar-month-year">
                            <span id="current-month"></span> <span id="current-year"></span>
                        </div>
                        <button id="next-month" class="calendar-nav-button">&gt;</button>
                    </div>
                    <div id="calendar-grid" class="calendar-grid"></div>
                </div>
                <!-- Rodapé com botão de eventos -->
                <div class="calendar-footer">
                    <button id="show-events-button">
                        <i class="bi bi-calendar-event"></i>
                        <span>Eventos</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pop-up para adicionar evento -->
    <div id="event-popup" class="event-popup">
        <div class="event-popup-content">
            <span class="close-popup">&times;</span>
            <h2>Adicionar Evento</h2>
            <input type="text" id="event-name" placeholder="Nome do evento">
            <textarea id="event-description" placeholder="Descrição do evento"></textarea>
            <input type="time" id="event-time" placeholder="Horário do evento">
            <button id="save-event">Salvar</button>
            <button id="exit-popup">Sair</button>
        </div>
    </div>

    <!-- Pop-up para listar eventos do mês -->
    <div id="events-list-popup" class="event-popup">
        <div class="event-popup-content">
            <span class="close-popup">&times;</span>
            <h2>Eventos do Mês</h2>
            <ul id="events-list"></ul>
        </div>
    </div>

    <script src="../javaScript/sidebar.js"></script>
    <script src="../javaScript/TelaCalendario.js"></script>
</body>

</html>