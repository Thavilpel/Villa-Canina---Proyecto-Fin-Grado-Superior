let mascotas = [];
let listaActual = []; // lista que se está mostrando (filtrada o no)
let visibles = 8;     // 👈 solo 8 al inicio

// Función para mostrar las mascotas en HTML
function mostrarMascotas(lista) {
    const contenedor = document.getElementById('lista-mascotas');
    const btnMostrar = document.getElementById('btn-mostrar-mas');

    contenedor.innerHTML = '';

    if (!lista.length) {
        contenedor.innerHTML = `<p class="text-center">No se encontraron mascotas</p>`;
        btnMostrar.style.display = "none";
        return;
    }

    listaActual = lista;

    lista.slice(0, visibles).forEach(m => {

        // Emoji según edad
        let emojiEdad = "🐶";
        const edadNum = parseInt(m.edad);

        if (!isNaN(edadNum)) {
            if (edadNum <= 1) {
                emojiEdad = "🐶";
            } else if (edadNum <= 5) {
                emojiEdad = "🐕";
            } else {
                emojiEdad = "🐕‍🦺";
            }
        }

        // Emoji según género
        let emojiGenero = "";
        if (m.genero === "M") {
            emojiGenero = "♂️";
        } else if (m.genero === "F") {
            emojiGenero = "♀️";
        }

        const card = document.createElement('div');
        card.className = 'col-12 col-sm-6 col-md-4 col-lg-3 mb-4';

        card.innerHTML = `
            <div class="card h-100 shadow-sm tarjeta-mascota" id="tarjeta">
                <img src="../public/img/mascotas/${m.imagen || 'default.png'}" 
                    class="card-img-top img-mascota" 
                    alt="${m.nombre}">
                
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">
                        › ${m.nombre} ‹
                    </h5>
                    <hr>
                    <p class="card-text">
                        <strong>🐾 Raza:</strong> ${m.raza || '-'}
                    </p>
                    
                    <p class="card-text">
                        <strong>${emojiEdad} Edad:</strong> ${m.edad || '-'} años 
                    </p>
                    
                    <p class="card-text">
                        <strong>${emojiGenero} Sexo:</strong> ${m.genero || '-'} 
                    </p>
                </div>
            </div>
        `;

        contenedor.appendChild(card);
    });

    // Mostrar u ocultar botón
    if (visibles >= lista.length) {
        btnMostrar.style.display = "none";
    } else {
        btnMostrar.style.display = "inline-block";
    }
}

// Evento botón mostrar más
document.getElementById('btn-mostrar-mas').addEventListener('click', () => {
    visibles += 4; // 👈 muestra 4 más cada click
    mostrarMascotas(listaActual);
});

// Cargar mascotas desde la API
async function cargarMascotas() {
    try {
        const res = await fetch('../api/api_mascotas.php');
        const datos = await res.json();

        // Solo mascotas disponibles
        mascotas = datos.filter(m => m.estado === 'disponible');

        visibles = 8; // reset
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

        const coincideSexo = sexo ? m.genero === sexo : true;
        const coincideRaza = raza ? (m.raza || '').toLowerCase().includes(raza) : true;

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

    visibles = 8; // 👈 resetear cuando se filtra
    mostrarMascotas(filtradas);
}

// Eventos de los filtros
document.getElementById('filtro-sexo').addEventListener('change', filtrarMascotas);
document.getElementById('filtro-edad').addEventListener('change', filtrarMascotas);
document.getElementById('filtro-raza').addEventListener('input', filtrarMascotas);

// Cargar al inicio
cargarMascotas();
