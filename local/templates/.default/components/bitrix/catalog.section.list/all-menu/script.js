addEventListener('DOMContentLoaded', () => {
    let mainMenuLink = document.querySelector('aside .category-list span.main-menu-link');

    if (mainMenuLink) {
        if (location.pathname !== '/') {
            mainMenuLink.style.cursor = 'pointer';
            mainMenuLink.classList.add('hover');
            mainMenuLink.onclick = () => {
                location.href = '/';
            }
        }
    }
});