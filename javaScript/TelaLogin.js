document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const confirmationMessage = document.getElementById('confirmationMessage');
    const transitionScreen = document.getElementById('transitionScreen');

   
    registerBtn.addEventListener('click', () => container.classList.add("active"));
    loginBtn.addEventListener('click', () => container.classList.remove("active"));

 
    function showMessage(message, isError = false) {
        confirmationMessage.textContent = message;
        confirmationMessage.className = 'confirmation-message ' + (isError ? 'error' : 'success');
        confirmationMessage.style.display = 'block';
        
        setTimeout(() => {
            confirmationMessage.style.opacity = '0';
            setTimeout(() => {
                confirmationMessage.style.display = 'none';
                confirmationMessage.style.opacity = '1';
            }, 300);
        }, 3000);
    }

    
    function validatePassword(password) {
        const errors = [];
        
        if (password.length < 8) {
            errors.push('A senha deve ter pelo menos 8 caracteres');
        }
        
        if (!/[A-Z]/.test(password)) {
            errors.push('A senha deve conter pelo menos uma letra maiúscula');
        }
        
        if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            errors.push('A senha deve conter pelo menos um símbolo');
        }
        
        return errors;
    }

    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = this.email.value;
        const senha = this.password.value;

        if (!email || !senha) {
            showMessage('Preencha todos os campos', true);
            return;
        }

        showMessage('Verificando credenciais...');

        fetch('processar_login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(senha)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Login realizado com sucesso!');
                transitionScreen.classList.add('active');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                showMessage(data.message || 'E-mail ou senha incorretos', true);
            }
        })
        .catch(() => showMessage('Erro ao conectar com o servidor', true));
    });

 
    signupForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = this.email.value;
        const senha = this.password.value;

        if (!email || !senha) {
            showMessage('Preencha todos os campos', true);
            return;
        }

        const passwordErrors = validatePassword(senha);
        if (passwordErrors.length > 0) {
            showMessage(passwordErrors.join(', '), true);
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
                showMessage('Cadastro realizado com sucesso!');
                this.reset();
                container.classList.remove("active");
                
                if (data.redirect) {
                    transitionScreen.classList.add('active');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                }
            } else {
                showMessage(data.message || 'Erro ao cadastrar', true);
            }
        })
        .catch(() => showMessage('Erro ao conectar', true));
    });

    
    document.querySelectorAll('a.forgot-password').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            transitionScreen.classList.add('active');
            setTimeout(() => {
                window.location.href = 'esqueceu_senha.php';
            }, 800);
        });
    });
});

function validateEmail(email) {
    const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return re.test(email);
}

loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = this.email.value.trim();
    const senha = this.password.value;

    if (!email || !senha) {
        showMessage('Preencha todos os campos', true);
        return;
    }

    if (!validateEmail(email)) {
        showMessage('Por favor, insira um e-mail válido (exemplo@dominio.com)', true);
        return;
    }

   
});


signupForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = this.email.value.trim();
    const senha = this.password.value;

    if (!email || !senha) {
        showMessage('Preencha todos os campos', true);
        return;
    }

    if (!validateEmail(email)) {
        showMessage('Por favor, insira um e-mail válido (exemplo@dominio.com)', true);
        return;
    }

    
});
