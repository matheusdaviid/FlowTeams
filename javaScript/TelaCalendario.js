document.addEventListener('DOMContentLoaded', function () {
    const calendarGrid = document.getElementById('calendar-grid');
    const currentMonthElement = document.getElementById('current-month');
    const currentYearElement = document.getElementById('current-year');
    const prevMonthButton = document.getElementById('prev-month');
    const nextMonthButton = document.getElementById('next-month');
    const showEventsButton = document.getElementById('show-events-button');
    const eventPopup = document.getElementById('event-popup');
    const eventsListPopup = document.getElementById('events-list-popup');
    const closePopup = document.querySelectorAll('.close-popup');
    const saveEventButton = document.getElementById('save-event');
    const exitPopupButton = document.getElementById('exit-popup');
    const eventNameInput = document.getElementById('event-name');
    const eventDescriptionInput = document.getElementById('event-description');
    const eventTimeInput = document.getElementById('event-time');
    const eventPriorityInput = document.getElementById('event-priority');
    const eventsList = document.getElementById('events-list');
    const totalEventsElement = document.getElementById('total-events');
    const importantEventsElement = document.getElementById('important-events');

    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let selectedDay = null;
    let events = JSON.parse(localStorage.getItem('calendarEvents')) || {};

    function updateCalendar() {
        calendarGrid.innerHTML = '';
        const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
        const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
        const daysInMonth = lastDayOfMonth.getDate();
        const startingDay = firstDayOfMonth.getDay();
        const today = new Date();

        currentMonthElement.textContent = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(firstDayOfMonth);
        currentYearElement.textContent = currentYear;

        for (let i = 0; i < startingDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.classList.add('day');
            calendarGrid.appendChild(emptyDay);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('day');
            dayElement.textContent = day;

            // Verifica se é o dia atual
            if (day === today.getDate() && currentMonth === today.getMonth() && currentYear === today.getFullYear()) {
                dayElement.classList.add('today');
            }

            const eventKey = `${currentYear}-${currentMonth + 1}-${day}`;
            if (events[eventKey]) {
                dayElement.classList.add('event');
                
                // Adiciona informações dos eventos no dia
                const dayEvents = document.createElement('div');
                dayEvents.classList.add('day-events');
                dayEvents.textContent = events[eventKey].name;
                dayElement.appendChild(dayEvents);
            }

            dayElement.addEventListener('click', () => {
                selectedDay = eventKey;
                eventPopup.style.display = 'flex';
            });

            calendarGrid.appendChild(dayElement);
        }
        
        updateStats();
    }

    function updateStats() {
        const monthEvents = Object.keys(events).filter(key => key.startsWith(`${currentYear}-${currentMonth + 1}`));
        const importantCount = monthEvents.filter(key => events[key].priority === 'important' || events[key].priority === 'urgent').length;
        
        totalEventsElement.textContent = `${monthEvents.length} ${monthEvents.length === 1 ? 'evento' : 'eventos'}`;
        importantEventsElement.textContent = `${importantCount} ${importantCount === 1 ? 'importante' : 'importantes'}`;
    }

    function showEventsList() {
        eventsList.innerHTML = '';
        const monthEvents = Object.keys(events).filter(key => key.startsWith(`${currentYear}-${currentMonth + 1}`));
        
        if (monthEvents.length === 0) {
            eventsList.innerHTML = '<li style="padding: 20px; text-align: center; color: #666;">Nenhum evento encontrado para este mês.</li>';
        } else {
            monthEvents.forEach(key => {
                const event = events[key];
                const eventItem = document.createElement('li');
                
                eventItem.innerHTML = `
                    <div class="event-info">
                        <div class="event-name">${event.name}</div>
                        <div class="event-details">
                            ${event.description ? event.description + ' • ' : ''}
                            ${event.time || 'Horário não definido'} • 
                            Dia ${key.split('-')[2]}
                        </div>
                    </div>
                `;
                
                const deleteButton = document.createElement('button');
                deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                deleteButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (confirm(`Deseja realmente excluir o evento "${event.name}"?`)) {
                        delete events[key];
                        localStorage.setItem('calendarEvents', JSON.stringify(events));
                        updateCalendar();
                        showEventsList();
                    }
                });

                eventItem.appendChild(deleteButton);
                eventItem.addEventListener('click', () => {
                    // Permite editar o evento ao clicar nele
                    selectedDay = key;
                    eventNameInput.value = event.name;
                    eventDescriptionInput.value = event.description || '';
                    eventTimeInput.value = event.time || '';
                    eventPriorityInput.value = event.priority || 'normal';
                    
                    eventsListPopup.style.display = 'none';
                    eventPopup.style.display = 'flex';
                });

                eventsList.appendChild(eventItem);
            });
        }
        eventsListPopup.style.display = 'flex';
    }

    prevMonthButton.addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendar();
    });

    nextMonthButton.addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    });

    showEventsButton.addEventListener('click', showEventsList);

    closePopup.forEach(button => {
        button.addEventListener('click', () => {
            eventPopup.style.display = 'none';
            eventsListPopup.style.display = 'none';
        });
    });

    saveEventButton.addEventListener('click', async () => {
        const eventName = eventNameInput.value.trim();
        const eventDescription = eventDescriptionInput.value.trim();
        const eventTime = eventTimeInput.value;
        const eventPriority = eventPriorityInput.value;

        if (eventName && selectedDay) {
            try {
                const response = await fetch('processar_evento.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'nome_evento': eventName,
                        'descricao': eventDescription,
                        'horario': eventTime,
                        'prioridade': eventPriority,
                        'data_evento': selectedDay
                    })
                });

                const result = await response.json();

                if (result.success) {
                    // Atualiza tanto o localStorage quanto a exibição
                    events[selectedDay] = { 
                        name: eventName, 
                        description: eventDescription, 
                        time: eventTime, 
                        priority: eventPriority 
                    };
                    
                    localStorage.setItem('calendarEvents', JSON.stringify(events));
                    updateCalendar();
                    eventPopup.style.display = 'none';
                    eventNameInput.value = '';
                    eventDescriptionInput.value = '';
                    eventTimeInput.value = '';
                    eventPriorityInput.value = 'normal';
                } else {
                    alert(result.message || 'Erro ao salvar evento');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao conectar com o servidor');
            }
        } else if (!eventName) {
            alert('Por favor, insira um nome para o evento.');
        }
    });

    exitPopupButton.addEventListener('click', () => {
        eventPopup.style.display = 'none';
        eventNameInput.value = '';
        eventDescriptionInput.value = '';
        eventTimeInput.value = '';
        eventPriorityInput.value = 'normal';
    });

    // Fechar pop-ups ao clicar fora deles
    window.addEventListener('click', (event) => {
        if (event.target === eventPopup) {
            eventPopup.style.display = 'none';
        }
        if (event.target === eventsListPopup) {
            eventsListPopup.style.display = 'none';
        }
    });

    // Inicializa o calendário
    updateCalendar();
});