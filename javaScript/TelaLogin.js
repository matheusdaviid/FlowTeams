document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const confirmationMessage = document.getElementById('confirmationMessage');

    // Alternar entre login e cadastro
    registerBtn.addEventListener('click', () => container.classList.add("active"));
    loginBtn.addEventListener('click', () => container.classList.remove("active"));

    // Mostrar mensagens
    function showMessage(message, isError = false) {
        confirmationMessage.textContent = message;
        confirmationMessage.style.color = isError ? 'red' : 'green';
        confirmationMessage.style.display = 'block';
        setTimeout(() => confirmationMessage.style.display = 'none', 3000);
    }

    // Login
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = this.email.value;
        const senha = this.password.value;

        if (!email || !senha) {
            showMessage('Preencha todos os campos', true);
            return;
        }

        showMessage('Entrando...');

        fetch('processar_login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(senha)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message);
                setTimeout(() => window.location.href = 'TelaInicial.php', 1000);
            } else {
                showMessage(data.message, true);
            }
        })
        .catch(() => showMessage('Erro ao conectar', true));
    });

    // Cadastro
    signupForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = this.email.value;
        const senha = this.password.value;

        if (!email || !senha) {
            showMessage('Preencha todos os campos', true);
            return;
        }

        showMessage('Cadastrando...');

        fetch('processar_cadastro.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(senha)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message);
                this.reset();
                container.classList.remove("active");
            } else {
                showMessage(data.message, true);
            }
        })
        .catch(() => showMessage('Erro ao conectar', true));
    });
});