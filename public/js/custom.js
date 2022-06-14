// Dashboard Sidebar Script
const btn = document.querySelector('.mobile-menu-button');
const btnClose = document.querySelector('.mobile-menu-close-button');
const sidebar = document.querySelector('.custom-sidebar');

btn.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
})
btnClose.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
})