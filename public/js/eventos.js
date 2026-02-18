// Detecta solo pantallas pequeñas
function setupMobileMenu() {
  if (window.innerWidth <= 788) {
    const toggles = document.querySelectorAll('.hacer-click');

    toggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const submenu = this.nextElementSibling;
        if (!submenu) return;

        submenu.classList.toggle('show');

        // girar flecha
        const arrow = this.querySelector('.girar');
        if (arrow) arrow.classList.toggle('open');
      });
    });
  }
}

// Ejecutar al cargar y al cambiar tamaño
window.addEventListener('load', setupMobileMenu);
window.addEventListener('resize', setupMobileMenu);
