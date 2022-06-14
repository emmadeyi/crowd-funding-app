// Dashboard Sidebar Script
const homeBtn = document.querySelector('button.home-mobile-menu-button');
const homeMenu = document.querySelector('.home-mobile-menu');

homeBtn.addEventListener('click', () => {
    homeMenu.classList.toggle("hidden");
});