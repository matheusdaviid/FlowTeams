document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('novaSenhaForm');
    const novaSenhaInput = document.getElementById('nova_senha');
    const confirmarSenhaInput = document.getElementById('confirmar_senha');
    
    // Validação em tempo real
    novaSenhaInput.addEventListener('input', function() {
        validatePassword(this.value);
    });
    
    // Validação ao enviar o formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const novaSenha = novaSenhaInput.value;
        const confirmarSenha = confirmarSenhaInput.value;
        
        // Validações
        if (novaSenha.length < 8) {
            showMessage('A senha deve ter pelo menos 8 caracteres.', true);
            return;
        }
        
        if (!/[A-Z]/.test(novaSenha)) {
            showMessage('A senha deve conter pelo menos uma letra maiúscula.', true);
            return;
        }
        
        if (!/[!@#$%^&*(),.?":{}|<>]/.test(novaSenha)) {
            showMessage('A senha deve conter pelo menos um símbolo.', true);
            return;
        }
        
        if (novaSenha !== confirmarSenha) {
            showMessage('As senhas não coincidem.', true);
            return;
        }
        
        // Se tudo estiver válido, envia o formulário
        this.submit();
    });
    
    function validatePassword(password) {
        // Atualiza os requisitos visuais
        document.getElementById('req-length').style.color = password.length >= 8 ? '#4CAF50' : '#ff0000';
        document.getElementById('req-uppercase').style.color = /[A-Z]/.test(password) ? '#4CAF50' : '#ff0000';
        document.getElementById('req-symbol').style.color = /[!@#$%^&*(),.?":{}|<>]/.test(password) ? '#4CAF50' : '#ff0000';
    }
    
    function showMessage(message, isError = false) {
        // Similar à função do esqueceu_senha.js
    }
});