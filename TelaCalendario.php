
<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: TelaLogin.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM tb_eventos WHERE id_usuario = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $eventsJson = json_encode($eventos);
} catch (PDOException $e) {
    $eventsJson = '[]';
}
try {
    $stmt = $pdo->prepare("SELECT *, DATE_FORMAT(data_evento, '%Y-%m-%d') as data_formatada FROM tb_eventos WHERE id_usuario = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Formata os eventos para o formato do JavaScript
    $formattedEvents = [];
    foreach ($eventos as $evento) {
        $key = $evento['data_formatada'];
        $formattedEvents[$key] = [
            'name' => $evento['nome_evento'],
            'description' => $evento['descricao_evento'],
            'time' => $evento['horario'],
            'priority' => $evento['prioridade']
        ];
    }
    $eventsJson = json_encode($formattedEvents);
} catch (PDOException $e) {
    $eventsJson = '{}';
}
?>
<script>
    const eventsFromDB = <?= $eventsJson ?>;
</script>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowTeams - Calendário</title>
    <link rel="stylesheet" href="./assets/css/TelaCalendario.css">
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
                <h1 class="calendar-title"><i class="bi bi-calendar2-date"></i> Calendário</h1>
                <div class="calendar">
                    <div class="calendar-header">
                        <button id="prev-month" class="calendar-nav-button" title="Mês anterior"><i class="bi bi-chevron-left"></i></button>
                        <div class="calendar-month-year">
                            <span id="current-month"></span> <span id="current-year"></span>
                        </div>
                        <button id="next-month" class="calendar-nav-button" title="Próximo mês"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    
                    <div class="calendar-grid" id="days-of-week">
                        <div class="day-of-week">Dom</div>
                        <div class="day-of-week">Seg</div>
                        <div class="day-of-week">Ter</div>
                        <div class="day-of-week">Qua</div>
                        <div class="day-of-week">Qui</div>
                        <div class="day-of-week">Sex</div>
                        <div class="day-of-week">Sáb</div>
                    </div>
                    
                    <div id="calendar-grid" class="calendar-grid"></div>
                </div>
                
                <!-- Rodapé com botão de eventos e estatísticas -->
                <div class="calendar-footer">
                    <div class="calendar-stats">
                        <div class="stat-box">
                            <i class="bi bi-calendar-event"></i>
                            <span id="total-events">0 eventos</span>
                        </div>
                        <div class="stat-box">
                            <i class="bi bi-star"></i>
                            <span id="important-events">0 importantes</span>
                        </div>
                    </div>
                    
                    <button id="show-events-button">
                        <i class="bi bi-calendar-event"></i>
                        <span>Ver Eventos</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pop-up para adicionar evento -->
    <div id="event-popup" class="event-popup">
        <div class="event-popup-content">
            <span class="close-popup">&times;</span>
            <h2><i class="bi bi-plus-circle"></i> Adicionar Evento</h2>
            <form id="event-form" method="POST">
                <input type="hidden" id="event-data" name="event-data">
                
                <label for="event-name">Nome do Evento</label>
                <input type="text" id="event-name" name="event-name" placeholder="Reunião com equipe" required>
                
                <label for="event-description">Descrição</label>
                <textarea id="event-description" name="event-description" placeholder="Detalhes do evento"></textarea>
                
                <label for="event-time">Horário</label>
                <input type="time" id="event-time" name="event-time" required>
                
                <label for="event-priority">Prioridade</label>
                <select id="event-priority" name="event-priority">
                    <option value="normal">Normal</option>
                    <option value="important">Importante</option>
                    <option value="urgent">Urgente</option>
                </select>
                
                <div class="button-group">
                    <button type="button" id="exit-popup" class="secondary">Cancelar</button>
                    <button type="submit" id="save-event">Salvar Evento</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pop-up para listar eventos do mês -->
    <div id="events-list-popup" class="event-popup">
        <div class="event-popup-content">
            <span class="close-popup">&times;</span>
            <h2><i class="bi bi-list-ul"></i> Eventos do Mês</h2>
            <ul id="events-list"></ul>
        </div>
    </div>

    <script>
        // Passa os eventos do PHP para o JavaScript
        const eventsFromDB = <?php echo $eventsJson; ?>;
    </script>
    <script src="./javaScript/sidebar.js"></script>
    <script src="./javaScript/TelaCalendario.js"></script>
</body>

</html>