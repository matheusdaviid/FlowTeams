// Função para configurar os switches
function setupAccessibilitySwitches() {
    const switches = {
        'shortcuts': false,
        'high-contrast': false,
        'captions': true,
        'open-links': false
    };

    // Carrega as configurações salvas
    Object.keys(switches).forEach(id => {
        const savedValue = localStorage.getItem(`setting_${id}`);
        if (savedValue !== null) {
            switches[id] = savedValue === 'true';
            document.getElementById(id).checked = switches[id];
        }
    });

    // Configura os event listeners
    Object.keys(switches).forEach(id => {
        document.getElementById(id).addEventListener('change', function() {
            localStorage.setItem(`setting_${id}`, this.checked);
        });
    });
}

// Função para alternar entre edição e leitura do e-mail
function toggleEmailEdit() {
    const emailInput = document.getElementById('email-input');
    const editButton = document.querySelector('.email-edit-container .edit-button');

    if (emailInput.readOnly) {
        emailInput.readOnly = false;
        emailInput.focus();
        editButton.innerHTML = '<i class="bi bi-check"></i> Salvar';
    } else {
        const newEmail = emailInput.value.trim();
        if (newEmail && newEmail.includes('@')) {
            // Envia a alteração para o servidor
            updateEmail(newEmail).then(success => {
                if (success) {
                    emailInput.readOnly = true;
                    editButton.innerHTML = '<i class="bi bi-pencil"></i> Editar';
                    alert('E-mail atualizado com sucesso!');
                } else {
                    alert('Erro ao atualizar o e-mail. Tente novamente.');
                }
            });
        } else {
            alert('Por favor, insira um e-mail válido.');
        }
    }
}

// Função para atualizar o e-mail no servidor
function updateEmail(newEmail) {
    return fetch('atualizar_email.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(newEmail)}`
    })
    .then(response => response.json())
    .then(data => data.success)
    .catch(() => false);
}
