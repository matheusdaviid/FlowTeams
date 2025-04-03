<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: TelaLogin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - FlowTeams</title>
    <link rel="stylesheet" href="./assets/css/Configuracoes.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
   
    <div class="sidebar">
        <div class="logo_content">
            <img src="./assets/img/logo-flowteams.png" alt="Logo FlowTeams" class="logo">
            <span class="logo_name">FlowTeams</span>
        </div>
        <div class="menu">
            <button onclick="window.location.href='./Telainicial.php'"><i class="bi bi-house"></i> <span class="menu_text">Início</span></button>
            <button onclick="window.location.href='./TelaProjetos.php'"><i class="bi bi-kanban"></i> <span class="menu_text">Projetos</span></button>
            <button onclick="window.location.href='./TelaCalendario.php'"><i class="bi bi-calendar2-date"></i> <span class="menu_text">Calendário</span></button>
        </div>
    </div>

 
    <div class="main-content">
      
        <div id="perfil" class="profile-section">
            <div class="profile-info">
          
                <div class="profile-icon-large">
                    <i class="bi bi-person-circle"></i>
                </div>
                <button class="upload-button">Faça upload da sua foto de perfil</button>
                <p>Isso serve para que os membros da sua equipe reconheçam você no FlowTeams.</p>
            </div>

    
            <div class="info-container">
                <div class="info-item">
                    <span>Endereço de e-mail</span>
                    <div class="email-edit-container">
                        <input type="email" id="email-input" value="<?php echo htmlspecialchars($_SESSION['usuario_email']); ?>" readonly>
                        <button class="edit-button" onclick="toggleEmailEdit()"><i class="bi bi-pencil"></i> Editar</button>
                    </div>
                </div>
            </div>
        </div>
       
        <div id="configuracoes" class="header">
            <h1>Configurações</h1>
        </div>

     
        <div class="settings-options">
            <h2>Geral</h2>
            <div class="option">
                <i class="bi bi-shield-lock"></i>
                <span>Login e Segurança</span>
            </div>
            <div class="option">
                <i class="bi bi-lock"></i>
                <span>Privacidade</span>
            </div>
            <div class="option">
                <i class="bi bi-palette"></i>
                <span>Aparência</span>
            </div>
            <div class="option">
                <i class="bi bi-chat-left-text"></i>
                <span>Feedbacks</span>
            </div>
            <div class="option">
                <i class="bi bi-cloud-arrow-up"></i>
                <span>Backup e Restauração</span>
            </div>
        </div>

       
        <div class="accessibility-settings">
            <h2>Acessibilidade</h2>
            <div class="setting">
                <label class="switch">
                    <input type="checkbox" id="shortcuts">
                    <span class="slider"></span>
                </label>
                <label for="shortcuts">Os atalhos de uma só tecla requerem o uso da tecla modificadora Alt.</label>
            </div>
            <div class="setting">
                <label class="switch">
                    <input type="checkbox" id="high-contrast">
                    <span class="slider"></span>
                </label>
                <label for="high-contrast">Alto contraste entre o texto e o fundo é mantido, incluindo fundos em gradiente.</label>
            </div>
            <div class="setting">
                <label class="switch">
                    <input type="checkbox" id="captions">
                    <span class="slider"></span>
                </label>
                <label for="captions">Legendas serão geradas e exibidas em todo o conteúdo de áudio e vídeo do FlowTeams que contenha falas.</label>
            </div>
            <div class="setting">
                <label class="switch">
                    <input type="checkbox" id="open-links">
                    <span class="slider"></span>
                </label>
                <label for="open-links">Os links do FlowTeams são abertos no app para computador, não no seu navegador.</label>
            </div>
        </div>
    </div>

    <script src="./javaScript/Configuracoes.js"></script>
</body>
</html>