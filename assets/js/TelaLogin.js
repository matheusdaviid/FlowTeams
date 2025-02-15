document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');
    const loginForm = document.getElementById('loginForm');
    const btnEntrar = document.getElementById('btnEntrar');
    const transitionOverlay = document.getElementById('transitionOverlay');

    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
    });

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Impede o envio do formulário

        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;

        if (email && senha) {
            // Inicia a animação de transição
            transitionOverlay.classList.add('fade-out');

            // Aguarda o término da animação antes de redirecionar
            setTimeout(() => {
                window.location.href = './TelaInicial.html';
            }, 1000); // Tempo da animação (1 segundo)
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });
});