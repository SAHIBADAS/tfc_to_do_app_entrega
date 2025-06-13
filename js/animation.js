document.addEventListener("DOMContentLoaded", () => {
    const articulos = document.querySelectorAll(".card-index");
    const arrow = document.getElementById("arrow-down");
    let visiblesCount = 0;

    const totalArticulos = articulos.length;

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible"); // Mostrar artículo
                observer.unobserve(entry.target); // Deja de observar ese artículo
                visiblesCount++;

                // Cuando todos los artículos estén visibles, oculta la flecha
                if (visiblesCount === totalArticulos && arrow) {
                    arrow.classList.add("hidden");
                }
            }
        });
    }, {
        threshold: 0.5 // El 50% del artículo debe ser visible
    });

    // Observar todos los artículos
    articulos.forEach(articulo => {
        observer.observe(articulo);
    });

});
