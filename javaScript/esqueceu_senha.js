document.addEventListener('DOMContentLoaded', function() {
    const resetForm = document.getElementById('resetForm');
    const novaSenhaForm = document.getElementById('novaSenhaForm');
    const messageDiv = document.getElementById('message');
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');
    const erro = urlParams.get('erro');
    const sucesso = urlParams.get('sucesso');

    
    if (erro) {
        showMessage(erro, 'error');
    }
    if (sucesso) {
        showMessage(sucesso, 'success');
    }

    
    if (sessionStorage.getItem('email_simulado')) {
        showMessage(sessionStorage.getItem('email_simulado'), 'info');
        sessionStorage.removeItem('email_simulado');
    }

    
    if (novaSenhaForm) {
        const novaSenhaInput = document.getElementById('nova_senha');
        
        novaSenhaInput.addEventListener('input', function() {
            validatePassword(this.value);
        });
    }

    
    if (resetForm) {
        resetForm.addEventListener('submit', function(e) {
            const email = this.email.value.trim();
            if (!validateEmail(email)) {
                e.preventDefault();
                showMessage('Por favor, insira um e-mail válido (exemplo@dominio.com)', 'error');
                return false;
            }
            return true;
        });
    }

    function validatePassword(password) {
        if (!password) return;
       
       
        const lengthValid = password.length >= 8;
        const upperValid = /[A-Z]/.test(password);
        const symbolValid = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        
        document.getElementById('req-length').style.color = lengthValid ? '#4CAF50' : '#ff0000';
        document.getElementById('req-uppercase').style.color = upperValid ? '#4CAF50' : '#ff0000';
        document.getElementById('req-symbol').style.color = symbolValid ? '#4CAF50' : '#ff0000';
        
        document.getElementById('req-length').classList.toggle('met', lengthValid);
        document.getElementById('req-uppercase').classList.toggle('met', upperValid);
        document.getElementById('req-symbol').classList.toggle('met', symbolValid);
    }

    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(email);
    }

    function showMessage(message, type) {
        messageDiv.textContent = message;
        messageDiv.className = 'alert ' + type;
        messageDiv.style.display = 'block';
        
        setTimeout(() => {
            messageDiv.style.opacity = '0';
            setTimeout(() => {
                messageDiv.style.display = 'none';
                messageDiv.style.opacity = '1';
            }, 300);
        }, 5000);
    }
});
