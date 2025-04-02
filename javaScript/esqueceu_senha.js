document.addEventListener('DOMContentLoaded', function() {
    const resetForm = document.getElementById('resetForm');
    
    if (resetForm) {
        resetForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.email.value.trim();
            const emailError = document.getElementById('email-error');
            
            // Validação básica do e-mail
            if (!email) {
                showMessage('Por favor, informe seu e-mail cadastrado.', true);
                return;
            }
            
            if (!validateEmail(email)) {
                showMessage('Por favor, informe um e-mail válido.', true);
                return;
            }
            
            // Mostrar loading
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
            
            // Simular verificação no servidor
            fetch('verificar_email.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `email=${encodeURIComponent(email)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    // Se o e-mail existe, envia o formulário
                    this.submit();
                } else {
                    showMessage('Este e-mail não está cadastrado em nosso sistema.', true);
                    btn.disabled = false;
                    btn.textContent = 'Enviar Link';
                }
            })
            .catch(() => {
                showMessage('Erro ao verificar e-mail. Tente novamente.', true);
                btn.disabled = false;
                btn.textContent = 'Enviar Link';
            });
        });
    }
    
    function showMessage(message, isError = false) {
        // Remove mensagens anteriores
        const oldAlerts = document.querySelectorAll('.alert');
        oldAlerts.forEach(alert => alert.remove());
        
        // Cria nova mensagem
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${isError ? 'error' : 'success'}`;
        alertDiv.textContent = message;
        
        // Insere após o span
        const formContainer = document.querySelector('.form-container');
        const span = formContainer.querySelector('span');
        span.insertAdjacentElement('afterend', alertDiv);
        
        // Remove após 5 segundos
        setTimeout(() => {
            alertDiv.style.opacity = '0';
            setTimeout(() => alertDiv.remove(), 300);
        }, 5000);
    }
    
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});