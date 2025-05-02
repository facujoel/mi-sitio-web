document.addEventListener('DOMContentLoaded', () => {
    // Suavizar el desplazamiento para los enlaces internos
    document.querySelectorAll('nav a, .hero a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});