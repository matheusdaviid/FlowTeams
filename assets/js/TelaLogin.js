document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const transitionOverlay = document.getElementById('transitionOverlay');
    const confirmationMessage = document.getElementById('confirmationMessage');

    // Toggle entre Entrar e Inscrever-se
    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
    });

    // Função para exibir mensagem de confirmação
    function showConfirmationMessage(message) {
        confirmationMessage.textContent = message;
        confirmationMessage.style.display = 'block';
        setTimeout(() => {
            confirmationMessage.style.display = 'none';
        }, 3000); // Mensagem desaparece após 3 segundos
    }

    // Formulário de Entrar
    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('loginEmail').value;
        const senha = document.getElementById('loginPassword').value;

        if (email && senha) {
            // Exibe a mensagem "Entrando..."
            showConfirmationMessage("Entrando...");

            // Inicia a animação de transição
            transitionOverlay.classList.add('fade-out');

            // Redireciona para a tela inicial após 1 segundo
            setTimeout(() => {
                window.location.href = './TelaInicial.html';
            }, 1000);
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });

    // Formulário de Inscrever-se
    signupForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('signupEmail').value;
        const senha = document.getElementById('signupPassword').value;

        if (email && senha) {
            // Salva os dados do usuário no localStorage
            localStorage.setItem('userEmail', email);
            localStorage.setItem('userPassword', senha);

            // Exibe a mensagem "Inscrição concluída"
            showConfirmationMessage("Inscrição concluída");

            // Limpa o formulário
            signupForm.reset();
        } else {
            alert('Por favor, preencha todos os campos.');
        }
        // Formulário de Entrar
loginForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const email = document.getElementById('loginEmail').value;
    const senha = document.getElementById('loginPassword').value;

    if (email && senha) {
        // Armazena o e-mail no localStorage
        localStorage.setItem('userEmail', email);

        // Exibe a mensagem "Entrando..."
        showConfirmationMessage("Entrando...");

        // Inicia a animação de transição
        transitionOverlay.classList.add('fade-out');

        // Redireciona para a tela inicial após 1 segundo
        setTimeout(() => {
            window.location.href = './TelaInicial.html';
        }, 1000);
    } else {
        alert('Por favor, preencha todos os campos.');
    }
});
    });
});