document.addEventListener('DOMContentLoaded', function () {
    const projectForm = document.getElementById('projectForm');
    const projectsGrid = document.getElementById('projectsGrid');
    const btnAlterar = document.querySelector('.btn-alterar');
    const btnExcluir = document.querySelector('.btn-excluir');

    let selectedProject = null; // Armazena o projeto selecionado para edição

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
        } else {
            // Adicionar novo projeto
            addProject(title, startDate, endDate, description);
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
        }
    });
});