let imgUser = document.createElement("img");
imgUser.src = "img/panel1.svg";

let estrellaAmarilla = document.createElement("img");
estrellaAmarilla.src = "img/eAmarilla.svg";

let estrellaGris = document.createElement("img");
estrellaGris.src = "img/eGris.svg";

let listadoReseñas;

// Función para mostrar la puntuación dentro del div
function mostrarPuntuacion(puntuacion, contenedorPuntuacion){
    for (let i = 0; i < 5; i++) {
        if(i < puntuacion){
            contenedorPuntuacion.innerHTML += `<img src="img/eAmarilla.svg" alt="Estrella amarilla">`;
        }else{
            contenedorPuntuacion.innerHTML += `<img src="img/eGris.svg" alt="Estrella gris">`;
        }
    }
}

// Llamar a la API para obtener reseñas usando fetch
fetch("http://localhost/laMallorquina/?controller=api&action=apiGetAllReviews")
.then(response => response.json())
.then(reseñasData => {
    let reseñasContainer = document.getElementById('reseñasContainer');
    listadoReseñas = reseñasData;
    // Mostrar la información de las reseñas en la página
    reseñasData.forEach( (reseña) => {
        let reseñaElemento = document.createElement('article');
        reseñaElemento.classList.add('col-12', 'col-md-6', 'col-lg-4', 'col-mb-3','panelFiltrar',parseInt(reseña.puntuacion));
        reseñaElemento.innerHTML = `
            <div class="seccionPanel d-flex">
                <img src="${imgUser.src}" alt="Foto de perfil del usuario"></img>
                <div class="infoContainer ps-3">
                    <div class="nombreEstrellas d-flex">
                        <div class="d-flex">
                            <p class="pe-1">${reseña.nombre_cliente}</p>
                            <p>${reseña.apellido_cliente}</p>
                        </div>
                        <div id="divPuntuacion" class="puntuacion"></div>
                    </div
                    <div class="infoOpinion d-flex flex-column align-items-start">
                        <p>${reseña.fecha}</p>
                        <p id="txtDescripcion">${reseña.descripcion}</p>
                    </div>
                </div>
            </div>
        `;
        reseñasContainer.appendChild(reseñaElemento);

        // Obtener el div que contiene la puntuación
        let contenedorPuntuacion = reseñaElemento.querySelector('.puntuacion');
        // Mostrar la puntuación dentro del div
        mostrarPuntuacion(reseña.puntuacion, contenedorPuntuacion);
    });
});



/*--- OBTENER INFORMACION DEL USUARIO ---*/

axios.get("http://localhost/laMallorquina/?controller=api&action=obtenerInfoUser")
    .then(response => {
        console.log("Información del usuario:", response.data);

        // Ejemplo: Actualizar elementos en la página con la información
        let tNombre = document.getElementById('nombre');
        let tApellido = document.getElementById('apellido');
        tNombre.textContent = response.data[0].nombre;
        tApellido.textContent = response.data[0].apellido;
    })
    .catch(error => {
        console.error("Error:", error);
    });
