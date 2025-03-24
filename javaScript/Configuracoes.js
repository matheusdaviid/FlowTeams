document.addEventListener('DOMContentLoaded', function () {
    // Recupera o idioma salvo ao carregar a página
    const userLanguage = localStorage.getItem('userLanguage') || 'Português (Brasil)';
    document.getElementById('language-text').textContent = userLanguage;

    // Configura os eventos dos switches de acessibilidade
    setupAccessibilitySwitches();
});

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

// Lista de idiomas
const languages = [
    { code: 'pt', name: 'Português (Brasil)' },
    { code: 'en', name: 'Inglês' },
    { code: 'es', name: 'Espanhol' },
    { code: 'fr', name: 'Francês' },
    { code: 'de', name: 'Alemão' },
    { code: 'zh', name: 'Chinês (Mandarim)' },
    { code: 'hi', name: 'Hindi' },
    { code: 'ar', name: 'Árabe' },
    { code: 'ru', name: 'Russo' },
    { code: 'ja', name: 'Japonês' },
    { code: 'it', name: 'Italiano' },
    { code: 'ko', name: 'Coreano' },
    { code: 'nl', name: 'Holandês' },
    { code: 'tr', name: 'Turco' },
    { code: 'sv', name: 'Sueco' }
];

// Função para abrir o modal de idiomas
function openLanguageModal() {
    const modal = document.getElementById('languageModal');
    const languageList = document.getElementById('language-list');

    // Limpa a lista de idiomas
    languageList.innerHTML = '';

    // Preenche a lista de idiomas
    languages.forEach(lang => {
        const li = document.createElement('li');
        li.textContent = lang.name;
        li.addEventListener('click', () => selectLanguage(lang));
        languageList.appendChild(li);
    });

    // Exibe o modal
    modal.style.display = 'flex';
}

// Função para fechar o modal de idiomas
function closeLanguageModal() {
    const modal = document.getElementById('languageModal');
    modal.style.display = 'none';
}

// Função para selecionar um idioma
function selectLanguage(lang) {
    localStorage.setItem('userLanguage', lang.name);
    document.getElementById('language-text').textContent = lang.name;
    closeLanguageModal();
}