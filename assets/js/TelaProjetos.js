document.addEventListener('DOMContentLoaded', function () {
    const projectForm = document.getElementById('projectForm');
    const projectsGrid = document.getElementById('projectsGrid');
    const btnAlterar = document.querySelector('.btn-alterar');
    const btnExcluir = document.querySelector('.btn-excluir');
    const successPopup = document.getElementById('successPopup');
    const successMessage = document.getElementById('successMessage');

    let selectedProject = null; // Armazena o projeto selecionado para edição

    // Função para exibir pop-up de sucesso
    function showSuccessPopup(message) {
        successMessage.textContent = message;
        successPopup.classList.add('show');
        setTimeout(() => {
            successPopup.classList.remove('show');
        }, 3000); // O pop-up desaparece após 3 segundos
    }

    // Função para validar as datas
    function validateDates(startDate, endDate) {
        // Verifica se as datas estão no formato correto (aaaa-mm-dd)
        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        if (!dateRegex.test(startDate) || !dateRegex.test(endDate)) {
            alert('Por favor, insira datas válidas no formato aaaa-mm-dd.');
            return false;
        }

        // Verifica se o ano tem exatamente 4 dígitos
        const startYear = startDate.split('-')[0];
        const endYear = endDate.split('-')[0];
        if (startYear.length !== 4 || endYear.length !== 4) {
            alert('O ano deve ter exatamente 4 dígitos.');
            return false;
        }

        // Verifica se a data de término é posterior à data de início
        const start = new Date(startDate);
        const end = new Date(endDate);
        if (start > end) {
            alert('A data de término deve ser posterior à data de início.');
            return false;
        }

        return true;
    }

    // Função para adicionar um projeto à lista
    function addProject(title, startDate, endDate, description) {
        const projectDiv = document.createElement('div');
        projectDiv.classList.add('project');
        projectDiv.innerHTML = `
            <div class="project-thumbnail"></div>
            <p>${title}</p>
            <small>Início: ${startDate} - Término: ${endDate}</small>
            <p class="project-description">${description}</p>
        `;

        // Adiciona evento de clique para selecionar o projeto
        projectDiv.addEventListener('click', () => {
            if (selectedProject) {
                selectedProject.classList.remove('selected');
            }
            selectedProject = projectDiv;
            selectedProject.classList.add('selected');
            btnExcluir.style.display = 'inline-block'; // Mostra o botão de excluir
        });

        projectsGrid.appendChild(projectDiv);
    }

    // Salvar projeto
    projectForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const title = document.getElementById('projectTitle').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const description = document.getElementById('projectDescription').value;

        // Valida as datas antes de prosseguir
        if (!validateDates(startDate, endDate)) {
            return; // Interrompe o envio se as datas forem inválidas
        }

        if (selectedProject) {
            // Editar projeto existente
            selectedProject.innerHTML = `
                <div class="project-thumbnail"></div>
                <p>${title}</p>
                <small>Início: ${startDate} - Término: ${endDate}</small>
                <p class="project-description">${description}</p>
            `;
            selectedProject.classList.remove('selected');
            selectedProject = null;
            btnExcluir.style.display = 'none'; // Oculta o botão de excluir
            showSuccessPopup('Alterado com sucesso!');
        } else {
            // Adicionar novo projeto
            addProject(title, startDate, endDate, description);
            showSuccessPopup('Salvo com sucesso!');
        }

        // Limpar o formulário
        projectForm.reset();
    });

    // Alterar projeto
    btnAlterar.addEventListener('click', function () {
        if (selectedProject) {
            // Preencher o formulário com os dados do projeto selecionado
            const title = selectedProject.querySelector('p').textContent;
            const dates = selectedProject.querySelector('small').textContent.split(' - ');
            const description = selectedProject.querySelector('.project-description').textContent;

            document.getElementById('projectTitle').value = title;
            document.getElementById('startDate').value = dates[0].replace('Início: ', '');
            document.getElementById('endDate').value = dates[1].replace('Término: ', '');
            document.getElementById('projectDescription').value = description;
        } else {
            alert('Selecione um projeto para editar.');
        }
    });

    // Excluir projeto
    btnExcluir.addEventListener('click', function () {
        if (selectedProject) {
            selectedProject.remove(); // Remove o projeto selecionado
            selectedProject = null;
            btnExcluir.style.display = 'none'; // Oculta o botão de excluir
            projectForm.reset(); // Limpa o formulário
            showSuccessPopup('Excluído com sucesso!');
        }
    });
});