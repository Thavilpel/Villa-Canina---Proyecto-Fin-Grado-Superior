let mascotas = [];

// Función para mostrar las mascotas en HTML
function mostrarMascotas(lista) {
    const contenedor = document.getElementById('lista-mascotas');
    contenedor.innerHTML = '';

    if (!lista.length) {
        contenedor.innerHTML = `<p class="text-center">No se encontraron mascotas</p>`;
        return;
    }

    lista.forEach(m => {
        const card = document.createElement('div');
        card.className = 'col-12 col-md-6 col-lg-4 mb-3';
        card.innerHTML = `
            <div class="card h-100">
                <img src="../img/avatar/${m.imagen || 'default.png'}" class="card-img-top" alt="${m.nombre}">
                <div class="card-body">
                    <h5 class="card-title">${m.nombre}</h5>
                    <p class="card-text">Raza: ${m.raza || '-'}</p>
                    <p class="card-text">Edad: ${m.edad || '-'}</p>
                    <p class="card-text">Sexo: ${m.genero || '-'}</p>
                </div>
            </div>
        `;
        contenedor.appendChild(card);
    });
}

// Cargar mascotas desde la API
async function cargarMascotas() {
    try {
        const res = await fetch('../api/api_mascotas.php');
        const datos = await res.json();
        // Solo mascotas disponibles
        mascotas = datos.filter(m => m.estado === 'disponible');
        mostrarMascotas(mascotas);
    } catch (error) {
        console.error('Error cargando mascotas:', error);
    }
}

// Función de filtrado por sexo, edad y raza
function filtrarMascotas() {
    const sexo = document.getElementById('filtro-sexo').value;
    const edad = document.getElementById('filtro-edad').value;
    const raza = document.getElementById('filtro-raza').value.toLowerCase();

    const filtradas = mascotas.filter(m => {
        // Sexo
        const coincideSexo = sexo ? m.genero === sexo : true;

        // Raza
        const coincideRaza = raza ? (m.raza || '').toLowerCase().includes(raza) : true;

        // Edad
        let coincideEdad = true;
        if (edad && m.edad !== null) {
            const a = parseInt(m.edad);
            switch (edad) {
                case '0-1': coincideEdad = a >= 0 && a <= 1; break;
                case '1-3': coincideEdad = a > 1 && a <= 3; break;
                case '3-7': coincideEdad = a > 3 && a <= 7; break;
                case '7+':  coincideEdad = a > 7; break;
            }
        }

        return coincideSexo && coincideRaza && coincideEdad;
    });

    mostrarMascotas(filtradas);
}

// Eventos de los filtros
document.getElementById('filtro-sexo').addEventListener('change', filtrarMascotas);
document.getElementById('filtro-edad').addEventListener('change', filtrarMascotas);
document.getElementById('filtro-raza').addEventListener('input', filtrarMascotas);

// Cargar al inicio
cargarMascotas();
