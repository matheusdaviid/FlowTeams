document.addEventListener('DOMContentLoaded', function () {
    const projectForm = document.getElementById('projectForm');
    const projectsGrid = document.querySelector('.projects-grid');
    const btnAlterar = document.querySelector('.btn-alterar');
    const btnExcluir = document.querySelector('.btn-excluir');
    const successPopup = document.getElementById('successPopup');
    const successMessage = document.getElementById('successMessage');

    let selectedProject = null;

    // Função para mostrar popup de sucesso
    function showSuccessPopup(message) {
        successMessage.textContent = message;
        successPopup.classList.add('show');
        setTimeout(() => {
            successPopup.classList.remove('show');
            window.location.reload();
        }, 2000);
    }

    // Função para validar datas
    function validateDates(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        if (start > end) {
            alert('A data de término deve ser posterior à data de início.');
            return false;
        }
        return true;
    }

    // Evento de submit do formulário
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
                btnExcluir.style.display = 'none';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao processar o projeto.');
        });
    });

    // Evento de clique nos cards de projeto
    projectsGrid.addEventListener('click', function(e) {
        const projectCard = e.target.closest('.project-card');
        if (!projectCard) return;

        // Remove seleção anterior
        if (selectedProject) {
            selectedProject.classList.remove('selected');
        }
        
        // Define novo projeto selecionado
        selectedProject = projectCard;
        selectedProject.classList.add('selected');
        
        // Mostra botões de edição e exclusão
        btnAlterar.style.display = 'inline-block';
        btnExcluir.style.display = 'inline-block';
    });

    // Evento de clique no botão Alterar
    btnAlterar.addEventListener('click', function() {
        if (selectedProject) {
            const projectId = selectedProject.getAttribute('data-id');
            const title = selectedProject.querySelector('h3').textContent;
            const description = selectedProject.querySelector('.project-description').textContent;
            
            // Extrai datas formatadas
            const dateElements = selectedProject.querySelectorAll('.project-meta span');
            const startDateText = dateElements[0].textContent.split(' ')[1];
            const endDateText = dateElements[1].textContent.split(' ')[1];
            
            // Converte formato dd/mm/yyyy para yyyy-mm-dd
            function brToUsDate(dateStr) {
                const [day, month, year] = dateStr.split('/');
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
            }

            document.getElementById('projectId').value = projectId;
            document.getElementById('projectTitle').value = title;
            document.getElementById('startDate').value = brToUsDate(startDateText);
            document.getElementById('endDate').value = brToUsDate(endDateText);
            document.getElementById('projectDescription').value = description;
        } else {
            alert('Selecione um projeto para editar.');
        }
    });

    // Evento de clique no botão Excluir
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

    // Esconde botões de ação inicialmente
    btnAlterar.style.display = 'none';
    btnExcluir.style.display = 'none';
});