document.addEventListener('DOMContentLoaded', function() {
    const notificationIcon = document.querySelector('.notification-icon');
    const notificationDropdown = document.createElement('div');
    notificationDropdown.className = 'notification-dropdown';
    notificationDropdown.innerHTML = `
        <h3>Notificações</h3>
        <p>Nenhuma notificação ainda</p>
    `;
    document.body.appendChild(notificationDropdown);

    notificationIcon.addEventListener('click', function(event) {
        event.stopPropagation();
        if (notificationDropdown.style.display === 'none' || notificationDropdown.style.display === '') {
            notificationDropdown.style.display = 'block';
        } else {
            notificationDropdown.style.display = 'none';
        }
    });

    document.addEventListener('click', function(event) {
        if (!notificationDropdown.contains(event.target) && event.target !== notificationIcon) {
            notificationDropdown.style.display = 'none';
        }
    });
});