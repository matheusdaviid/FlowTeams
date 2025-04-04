<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/TelaLogin.css">
    <title>Página de Login</title>
</head>

<body>
    <!-- Logo do site -->
    <div class="logo-container">
        <img src="./assets/img/logo-flowteams.png" alt="Logo FlowTeams">
    </div>

    <div class="container" id="container">
        <!-- Formulário de Inscrever-se -->
        <div class="form-container sign-up">
            <form id="signupForm" action="processar_cadastro.php" method="POST">
                <h1>Criar Conta</h1>
                <span>use seu e-mail para se Inscrever</span>
                <input type="email" id="signupEmail" name="email" placeholder="E-mail" required>
                <input type="password" id="signupPassword" name="password" placeholder="Senha" required>
                <button type="submit">Inscrever-se</button>
            </form>
        </div>

        <!-- Formulário de Entrar -->
        <div class="form-container sign-in">
            <form id="loginForm" action="processar_login.php" method="POST">
                <h1>Entrar</h1>
                <span>use seu e-mail e senha cadastrados</span>
                <input type="email" id="loginEmail" name="email" placeholder="E-mail" required>
                <input type="password" id="loginPassword" name="password" placeholder="Senha" required>
                <a href="esqueceu_senha.php" class="forgot-password">Esqueceu sua senha?</a>
                <button type="submit" id="btnEntrar">Entrar</button>
            </form>
        </div>

        <!-- Toggle entre Entrar e Inscrever-se -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bem-vindo de volta!</h1>
                    <p>Insira seus dados pessoais para usar todos os recursos do site</p>
                    <button class="hidden" id="login">Entrar</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Olá, Amigo!</h1>
                    <p>Cadastre-se com seus dados pessoais para usar todos os recursos do site</p>
                    <button class="hidden" id="register">Inscrever-se</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay de transição -->
    <div id="transitionOverlay"></div>

    <!-- Mensagens de confirmação -->
    <div id="confirmationMessage" class="confirmation-message"></div>

    <!-- Tela de transição simplificada -->
    <div class="transition-screen" id="transitionScreen">
        <div class="spinner"></div>
    </div>

    <script src="./javaScript/TelaLogin.js"></script>
</body>
</html>