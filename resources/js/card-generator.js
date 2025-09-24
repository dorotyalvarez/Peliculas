// Esta función toma un arreglo de películas y las renderiza en el contenedor.
function generarTarjetas(peliculas) {
    const contenedor = document.getElementById('tarjetas-container');

    if (!contenedor) {
        console.error('El contenedor "tarjetas-container" no fue encontrado.');
        return;
    }

    // Limpia el contenido actual del contenedor
    contenedor.innerHTML = '';

    peliculas.forEach(pelicula => {
        const col = document.createElement('div');
        col.className = 'col';
        col.innerHTML = `
            <div class="card h-100">
                <img src="${pelicula.imagen}" class="card-img-top" alt="${pelicula.titulo}">
                <div class="card-body text-center">
                    <h5 class="card-title">${pelicula.titulo}</h5>
                    <p class="card-text">${pelicula.descripcion}</p>
                    <a href="#" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        `;
        contenedor.appendChild(col);
    });
}