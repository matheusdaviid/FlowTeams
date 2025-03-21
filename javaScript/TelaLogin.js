document.addEventListener('DOMContentLoaded', function () {
    const signupForm = document.getElementById('signupForm');
    const loginForm = document.getElementById('loginForm');

    // Formulário de Inscrever-se
    signupForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('signupEmail').value;
        const senha = document.getElementById('signupPassword').value;

        if (email && senha) {
            // Envia os dados para o backend
            fetch('includes/processar_cadastro.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(senha)}`,
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Exibe a mensagem de sucesso ou erro
                if (data === "Cadastro realizado com sucesso!") {
                    signupForm.reset(); // Limpa o formulário
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });

    // Formulário de Entrar
    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const email = document.getElementById('loginEmail').value;
        const senha = document.getElementById('loginPassword').value;

        if (email && senha) {
            // Envia os dados para o backend
            fetch('includes/processar_login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(senha)}`,
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Exibe a mensagem de sucesso ou erro
                if (data === "Login bem-sucedido!") {
                    window.location.href = 'TelaInicial.php'; // Redireciona para a tela inicial
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });
});