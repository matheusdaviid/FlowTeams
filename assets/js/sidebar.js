// sidebar.js
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    sidebar.addEventListener('mouseenter', () => {
        sidebar.classList.add('active');
        mainContent.classList.add('sidebar-active');
    });

    sidebar.addEventListener('mouseleave', () => {
        sidebar.classList.remove('active');
        mainContent.classList.remove('sidebar-active');
    });
});