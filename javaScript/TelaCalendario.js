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
    const eventsList = document.getElementById('events-list');

    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let selectedDay = null;
    let events = {};

    function updateCalendar() {
        calendarGrid.innerHTML = '';
        const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
        const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
        const daysInMonth = lastDayOfMonth.getDate();
        const startingDay = firstDayOfMonth.getDay();

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

            const eventKey = `${currentYear}-${currentMonth + 1}-${day}`;
            if (events[eventKey]) {
                dayElement.classList.add('event');
            }

            dayElement.addEventListener('click', () => {
                selectedDay = eventKey;
                eventPopup.style.display = 'flex';
            });

            calendarGrid.appendChild(dayElement);
        }
    }

    function showEventsList() {
        eventsList.innerHTML = '';
        const monthEvents = Object.keys(events).filter(key => key.startsWith(`${currentYear}-${currentMonth + 1}`));
        if (monthEvents.length === 0) {
            eventsList.innerHTML = '<li>Nenhum evento encontrado para este mês.</li>';
        } else {
            monthEvents.forEach(key => {
                const event = events[key];
                const eventItem = document.createElement('li');
                eventItem.textContent = `${event.name} - ${event.description} (${event.time})`;
                
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Excluir';
                deleteButton.addEventListener('click', () => {
                    delete events[key];
                    updateCalendar();
                    showEventsList();
                });

                eventItem.appendChild(deleteButton);
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

    saveEventButton.addEventListener('click', () => {
        const eventName = eventNameInput.value;
        const eventDescription = eventDescriptionInput.value;
        const eventTime = eventTimeInput.value;

        if (eventName && selectedDay) {
            events[selectedDay] = { name: eventName, description: eventDescription, time: eventTime };
            updateCalendar();
            eventPopup.style.display = 'none';
            eventNameInput.value = '';
            eventDescriptionInput.value = '';
            eventTimeInput.value = '';
        }
    });

    exitPopupButton.addEventListener('click', () => {
        eventPopup.style.display = 'none';
    });

    updateCalendar();
});