document.addEventListener('DOMContentLoaded', function () {
    const projectForm = document.getElementById('projectForm');
    const projectsGrid = document.getElementById('projectsGrid');
    const btnAlterar = document.querySelector('.btn-alterar');
    const btnExcluir = document.querySelector('.btn-excluir');
    const successPopup = document.getElementById('successPopup');
    const successMessage = document.getElementById('successMessage');

    let selectedProject = null;

    // Função para exibir pop-up de sucesso
    function showSuccessPopup(message) {
        successMessage.textContent = message;
        successPopup.classList.add('show');
        setTimeout(() => {
            successPopup.classList.remove('show');
            window.location.reload(); // Recarrega a página para atualizar a lista
        }, 2000);
    }

    // Função para validar as datas
    function validateDates(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        if (start > end) {
            alert('A data de término deve ser posterior à data de início.');
            return false;
        }
        return true;
    }

    // Envio do formulário
    projectForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (!validateDates(startDate, endDate)) {
            return;
        }
        
        const formData = new FormData(projectForm);
        
        fetch('processar_projeto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessPopup(data.message);
                projectForm.reset();
                document.getElementById('projectId').value = '';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao processar o projeto.');
        });
    });

    // Seleciona projeto ao clicar
    projectsGrid.addEventListener('click', function(e) {
        const projectCard = e.target.closest('.project-card');
        if (!projectCard) return;

        // Remove a seleção anterior
        if (selectedProject) {
            selectedProject.classList.remove('selected');
        }
        
        // Adiciona a nova seleção
        selectedProject = projectCard;
        selectedProject.classList.add('selected');
        
        // Mostra o botão de excluir
        btnExcluir.style.display = 'inline-block';
    });

    // Alterar projeto
    btnAlterar.addEventListener('click', function() {
        if (selectedProject) {
            const projectId = selectedProject.getAttribute('data-id');
            const title = selectedProject.querySelector('h3').textContent;
            const description = selectedProject.querySelector('.project-description').textContent;
            
            // Obtém as datas dos spans
            const dateSpans = selectedProject.querySelectorAll('.project-meta span');
            const startDateText = dateSpans[0].textContent.replace(' Início: ', '').trim();
            const endDateText = dateSpans[1].textContent.replace(' Término: ', '').trim();
            
            // Converte datas do formato brasileiro para o formato do input date
            function brToDate(brDate) {
                const [day, month, year] = brDate.split('/');
                return `${year}-${month}-${day}`;
            }

            // Preenche o formulário com os dados do projeto selecionado
            document.getElementById('projectId').value = projectId;
            document.getElementById('projectTitle').value = title;
            document.getElementById('startDate').value = brToDate(startDateText);
            document.getElementById('endDate').value = brToDate(endDateText);
            document.getElementById('projectDescription').value = description;
        } else {
            alert('Selecione um projeto para editar.');
        }
    });

    // Excluir projeto
    btnExcluir.addEventListener('click', function() {
        if (selectedProject) {
            if (confirm('Tem certeza que deseja excluir este projeto?')) {
                const projectId = selectedProject.getAttribute('data-id');
                
                fetch('excluir_projeto.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${projectId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessPopup(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir projeto.');
                });
            }
        } else {
            alert('Selecione um projeto para excluir.');
        }
    });
});