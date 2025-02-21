document.addEventListener('DOMContentLoaded', function () {
    // Recupera o e-mail do localStorage
    const userEmail = localStorage.getItem('userEmail') || 'matheus.david@senacsp.edu.br';
    document.getElementById('email-input').value = userEmail;

    // Recupera o idioma salvo ao carregar a página
    const userLanguage = localStorage.getItem('userLanguage') || 'Português (Brasil)';
    document.getElementById('language-text').textContent = userLanguage;
});

// Função para alternar entre edição e leitura do e-mail
function toggleEmailEdit() {
    const emailInput = document.getElementById('email-input');
    const editButton = document.querySelector('.edit-button');

    if (emailInput.readOnly) {
        emailInput.readOnly = false;
        emailInput.focus();
        editButton.innerHTML = '<i class="bi bi-check"></i> Salvar';
    } else {
        const newEmail = emailInput.value.trim();
        if (newEmail && newEmail.includes('@')) {
            localStorage.setItem('userEmail', newEmail);
            emailInput.readOnly = true;
            editButton.innerHTML = '<i class="bi bi-pencil"></i> Editar';
        } else {
            alert('Por favor, insira um e-mail válido.');
        }
    }
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
    localStorage.setItem('userLanguage', lang.name); // Salva o idioma no localStorage
    document.getElementById('language-text').textContent = lang.name; // Atualiza o texto na tela
    closeLanguageModal(); // Fecha o modal
}