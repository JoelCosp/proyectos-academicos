/*--- MENU RESEÑAS ---*/

let formularioEstrella = document.getElementById("formularioEstrellas");
let parrafoOrden = document.getElementById("orden");
let imgEliminada = document.getElementsByTagName("img");

let primerClic = true;

let img1 = document.createElement("img");
img1.src = "img/unaEstrellas.svg";
let img2 = document.createElement("img");
img2.src = "img/dosEstrellas.svg";
let img3 = document.createElement("img");
img3.src = "img/tresEstrellas.svg";
let img4 = document.createElement("img");
img4.src = "img/cuatroEstrellas.svg";
let img5 = document.createElement("img");
img5.src = "img/cincoEstrellas.svg";
mostrarTodo = document.createElement("p");
mostrarTodo.innerHTML = "Mostrar todo";
ordenAsc = document.createElement("p");
ordenAsc.innerHTML = "Orden ascendente";
ordenDesc = document.createElement("p");
ordenDesc.innerHTML = "Orden descendente";

/*--- VARIABLES FILTRO PUNTUACION ---*/
let cat = document.getElementsByClassName("panelFiltrar");

function mostrarPuntuacion(puntuacion, contenedorPuntuacion){
    for (let i = 0; i < 5; i++) {
        if(i < puntuacion){
            contenedorPuntuacion.innerHTML += `<img src="img/eAmarilla.svg" alt="Estrella amarilla">`;
        }else{
            contenedorPuntuacion.innerHTML += `<img src="img/eGris.svg" alt="Estrella gris">`;
        }
    }
}

formularioEstrella.addEventListener( "click", (event) => {
    if (event.target === formularioEstrella) {
        if(primerClic){
            formularioEstrella.classList.add("botonAbierto");
            formularioEstrella.innerText = "Filtrar por: ▲"
            formularioEstrella.style.display = "flex";
            formularioEstrella.style.flexDirection = "column"; 
            

            let listaEstrellas = [img5, img4, img3, img2, img1, ordenAsc, ordenDesc, mostrarTodo];

            for (let i = 0; i < listaEstrellas.length; i++) {
                formularioEstrella.appendChild(listaEstrellas[i]);
            }

            primerClic = false;
        }else{
            formularioEstrella.innerHTML = "Filtrar por: ▼"; // Corregido aquí
            primerClic = true;
        }
    } else {
        if (event.target === img5) {
            let cat5 = listadoReseñas.filter((e) => e.puntuacion == "5.0");
            console.log(cat5);
        
            // Limpiar el contenedor antes de agregar las reseñas filtradas
            reseñasContainer.innerHTML = "";
        
            cat5.forEach((data) => {
                // Crear un elemento de artículo
                let reseñaElemento = document.createElement('article');
                reseñaElemento.classList.add('col-12', 'col-md-6', 'col-lg-4', 'col-mb-3', 'panelFiltrar', parseInt(data.puntuacion));
        
                // Crear la estructura interna del elemento
                reseñaElemento.innerHTML = `
                    <div class="seccionPanel d-flex">
                        <img src="${imgUser.src}" alt="Foto de perfil del usuario"></img>
                        <div class="infoContainer ps-3">
                            <div class="nombreEstrellas d-flex">
                                <div class="d-flex">
                                    <p class="pe-1">${data.nombre_cliente}</p>
                                    <p>${data.apellido_cliente}</p>
                                </div>
                                <div id="divPuntuacion" class="puntuacion"></div>
                            </div>
                            <div class="infoOpinion d-flex flex-column align-items-start">
                                <p>${data.fecha}</p>
                                <p id="txtDescripcion">${data.descripcion}</p>
                            </div>
                        </div>
                    </div>
                `;
        
                // Agregar el elemento al contenedor
                reseñasContainer.appendChild(reseñaElemento);
                let contenedorPuntuacion = reseñaElemento.querySelector('.puntuacion');
                mostrarPuntuacion(data.puntuacion, contenedorPuntuacion);
            });
        } else if (event.target === img4) {
            let cat5 = listadoReseñas.filter((e) => e.puntuacion == "4.0");
            console.log(cat5);
        
            // Limpiar el contenedor antes de agregar las reseñas filtradas
            reseñasContainer.innerHTML = "";
        
            cat5.forEach((data) => {
                // Crear un elemento de artículo
                let reseñaElemento = document.createElement('article');
                reseñaElemento.classList.add('col-12', 'col-md-6', 'col-lg-4', 'col-mb-3', 'panelFiltrar', parseInt(data.puntuacion));
        
                // Crear la estructura interna del elemento
                reseñaElemento.innerHTML = `
                    <div class="seccionPanel d-flex">
                        <img src="${imgUser.src}" alt="Foto de perfil del usuario"></img>
                        <div class="infoContainer ps-3">
                            <div class="nombreEstrellas d-flex">
                                <div class="d-flex">
                                    <p class="pe-1">${data.nombre_cliente}</p>
                                    <p>${data.apellido_cliente}</p>
                                </div>
                                <div id="divPuntuacion" class="puntuacion"></div>
                            </div>
                            <div class="infoOpinion d-flex flex-column align-items-start">
                                <p>${data.fecha}</p>
                                <p id="txtDescripcion">${data.descripcion}</p>
                            </div>
                        </div>
                    </div>
                `;
        
                // Agregar el elemento al contenedor
                reseñasContainer.appendChild(reseñaElemento);
                let contenedorPuntuacion = reseñaElemento.querySelector('.puntuacion');
                mostrarPuntuacion(data.puntuacion, contenedorPuntuacion);
            });
        } else if (event.target === img3) {
            let cat5 = listadoReseñas.filter((e) => e.puntuacion == "3.0");
            console.log(cat5);
        
            // Limpiar el contenedor antes de agregar las reseñas filtradas
            reseñasContainer.innerHTML = "";
        
            cat5.forEach((data) => {
                // Crear un elemento de artículo
                let reseñaElemento = document.createElement('article');
                reseñaElemento.classList.add('col-12', 'col-md-6', 'col-lg-4', 'col-mb-3', 'panelFiltrar', parseInt(data.puntuacion));
        
                // Crear la estructura interna del elemento
                reseñaElemento.innerHTML = `
                    <div class="seccionPanel d-flex">
                        <img src="${imgUser.src}" alt="Foto de perfil del usuario"></img>
                        <div class="infoContainer ps-3">
                            <div class="nombreEstrellas d-flex">
                                <div class="d-flex">
                                    <p class="pe-1">${data.nombre_cliente}</p>
                                    <p>${data.apellido_cliente}</p>
                                </div>
                                <div id="divPuntuacion" class="puntuacion"></div>
                            </div>
                            <div class="infoOpinion d-flex flex-column align-items-start">
                                <p>${data.fecha}</p>
                                <p id="txtDescripcion">${data.descripcion}</p>
                            </div>
                        </div>
                    </div>
                `;
        
                // Agregar el elemento al contenedor
                reseñasContainer.appendChild(reseñaElemento);
                let contenedorPuntuacion = reseñaElemento.querySelector('.puntuacion');
                mostrarPuntuacion(data.puntuacion, contenedorPuntuacion);
            });
        } else if (event.target === img2) {
            let cat5 = listadoReseñas.filter((e) => e.puntuacion == "2.0");
            console.log(cat5);
        
            // Limpiar el contenedor antes de agregar las reseñas filtradas
            reseñasContainer.innerHTML = "";
        
            cat5.forEach((data) => {
                // Crear un elemento de artículo
                let reseñaElemento = document.createElement('article');
                reseñaElemento.classList.add('col-12', 'col-md-6', 'col-lg-4', 'col-mb-3', 'panelFiltrar', parseInt(data.puntuacion));
        
                // Crear la estructura interna del elemento
                reseñaElemento.innerHTML = `
                    <div class="seccionPanel d-flex">
                        <img src="${imgUser.src}" alt="Foto de perfil del usuario"></img>
                        <div class="infoContainer ps-3">
                            <div class="nombreEstrellas d-flex">
                                <div class="d-flex">
                                    <p class="pe-1">${data.nombre_cliente}</p>
                                    <p>${data.apellido_cliente}</p>
                                </div>
                                <div id="divPuntuacion" class="puntuacion"></div>
                            </div>
                            <div class="infoOpinion d-flex flex-column align-items-start">
                                <p>${data.fecha}</p>
                                <p id="txtDescripcion">${data.descripcion}</p>
                            </div>
                        </div>
                    </div>
                `;
        
                // Agregar el elemento al contenedor
                reseñasContainer.appendChild(reseñaElemento);
                let contenedorPuntuacion = reseñaElemento.querySelector('.puntuacion');
                mostrarPuntuacion(data.puntuacion, contenedorPuntuacion);
            });
        } else if (event.target === img1) {
            let cat5 = listadoReseñas.filter((e) => e.puntuacion == "1.0");
            console.log(cat5);
        
            // Limpiar el contenedor antes de agregar las reseñas filtradas
            reseñasContainer.innerHTML = "";
        
            cat5.forEach((data) => {
                // Crear un elemento de artículo
                let reseñaElemento = document.createElement('article');
                reseñaElemento.classList.add('col-12', 'col-md-6', 'col-lg-4', 'col-mb-3', 'panelFiltrar', parseInt(data.puntuacion));
        
                // Crear la estructura interna del elemento
                reseñaElemento.innerHTML = `
                    <div class="seccionPanel d-flex">
                        <img src="${imgUser.src}" alt="Foto de perfil del usuario"></img>
                        <div class="infoContainer ps-3">
                            <div class="nombreEstrellas d-flex">
                                <div class="d-flex">
                                    <p class="pe-1">${data.nombre_cliente}</p>
                                    <p>${data.apellido_cliente}</p>
                                </div>
                                <div id="divPuntuacion" class="puntuacion"></div>
                            </div>
                            <div class="infoOpinion d-flex flex-column align-items-start">
                                <p>${data.fecha}</p>
                                <p id="txtDescripcion">${data.descripcion}</p>
                            </div>
                        </div>
                    </div>
                `;
                // Agregar el elemento al contenedor
                reseñasContainer.appendChild(reseñaElemento);
                let contenedorPuntuacion = reseñaElemento.querySelector('.puntuacion');
                mostrarPuntuacion(data.puntuacion, contenedorPuntuacion);
            });
        } else if(event.target === ordenAsc) {
            let cat5 = listadoReseñas.filter((e) => e.puntuacion >= "1.0" && e.puntuacion <= "5.0");
            let listaAsc = cat5.sort((a, b) => parseFloat(a.puntuacion) - parseFloat(b.puntuacion));

            reseñasContainer.innerHTML = "";

            listaAsc.forEach((data) => {
                // Crear un elemento de artículo
                let reseñaElemento = document.createElement('article');
                reseñaElemento.classList.add('col-12', 'col-md-6', 'col-lg-4', 'col-mb-3', 'panelFiltrar', parseInt(data.puntuacion));
        
                // Crear la estructura interna del elemento
                reseñaElemento.innerHTML = `
                    <div class="seccionPanel d-flex">
                        <img src="${imgUser.src}" alt="Foto de perfil del usuario"></img>
                        <div class="infoContainer ps-3">
                            <div class="nombreEstrellas d-flex">
                                <div class="d-flex">
                                    <p class="pe-1">${data.nombre_cliente}</p>
                                    <p>${data.apellido_cliente}</p>
                                </div>
                                <div id="divPuntuacion" class="puntuacion"></div>
                            </div>
                            <div class="infoOpinion d-flex flex-column align-items-start">
                                <p>${data.fecha}</p>
                                <p id="txtDescripcion">${data.descripcion}</p>
                            </div>
                        </div>
                    </div>
                `;
        
                // Agregar el elemento al contenedor
                reseñasContainer.appendChild(reseñaElemento);
                let contenedorPuntuacion = reseñaElemento.querySelector('.puntuacion');
                mostrarPuntuacion(data.puntuacion, contenedorPuntuacion);
            });

        } else if(event.target === ordenDesc) {
            let cat5 = listadoReseñas.filter((e) => e.puntuacion >= "1.0" && e.puntuacion <= "5.0");
            let listaAsc = cat5.sort((a, b) => parseFloat(b.puntuacion) - parseFloat(a.puntuacion));

            reseñasContainer.innerHTML = "";

            listaAsc.forEach((data) => {
                // Crear un elemento de artículo
                let reseñaElemento = document.createElement('article');
                reseñaElemento.classList.add('col-12', 'col-md-6', 'col-lg-4', 'col-mb-3', 'panelFiltrar', parseInt(data.puntuacion));
        
                // Crear la estructura interna del elemento
                reseñaElemento.innerHTML = `
                    <div class="seccionPanel d-flex">
                        <img src="${imgUser.src}" alt="Foto de perfil del usuario"></img>
                        <div class="infoContainer ps-3">
                            <div class="nombreEstrellas d-flex">
                                <div class="d-flex">
                                    <p class="pe-1">${data.nombre_cliente}</p>
                                    <p>${data.apellido_cliente}</p>
                                </div>
                                <div id="divPuntuacion" class="puntuacion"></div>
                            </div>
                            <div class="infoOpinion d-flex flex-column align-items-start">
                                <p>${data.fecha}</p>
                                <p id="txtDescripcion">${data.descripcion}</p>
                            </div>
                        </div>
                    </div>
                `;
        
                // Agregar el elemento al contenedor
                reseñasContainer.appendChild(reseñaElemento);
                let contenedorPuntuacion = reseñaElemento.querySelector('.puntuacion');
                mostrarPuntuacion(data.puntuacion, contenedorPuntuacion);
            });

        } else if(event.target === mostrarTodo){
            mostrarTodasReseñas();
        } 
    }
});


function mostrarTodasReseñas() {
    reseñasContainer.innerHTML = ""; // Limpiar el contenedor de reseñas

    // Volver a mostrar todas las reseñas
    listadoReseñas.forEach((data) => {
        // Crear un elemento de artículo
        let reseñaElemento = document.createElement("article");
        reseñaElemento.classList.add(
            "col-12",
            "col-md-6",
            "col-lg-4",
            "col-mb-3",
            "panelFiltrar",
            parseInt(data.puntuacion)
        );

        // Crear la estructura interna del elemento
        reseñaElemento.innerHTML = `
            <div class="seccionPanel d-flex">
                <img src="${imgUser.src}" alt="Foto de perfil del usuario"></img>
                <div class="infoContainer ps-3">
                    <div class="nombreEstrellas d-flex">
                        <div class="d-flex">
                            <p class="pe-1">${data.nombre_cliente}</p>
                            <p>${data.apellido_cliente}</p>
                        </div>
                        <div id="divPuntuacion" class="puntuacion"></div>
                    </div>
                    <div class="infoOpinion d-flex flex-column align-items-start">
                        <p>${data.fecha}</p>
                        <p id="txtDescripcion">${data.descripcion}</p>
                    </div>
                </div>
            </div>
        `;

        // Agregar el elemento al contenedor
        reseñasContainer.appendChild(reseñaElemento);
        let contenedorPuntuacion = reseñaElemento.querySelector(".puntuacion");
        mostrarPuntuacion(data.puntuacion, contenedorPuntuacion);
    });
}









/*--- IMPRIMIR PUNTUACION ESTRELLAS ---*/

let numsPuntuacion = document.getElementsByClassName("puntuacion");

let imgEstrella = document.createElement("img");
imgEstrella.src = "img/unaEstrellas.svg";

for (let i = 0; i < numsPuntuacion.length; i++) {
    switch (parseInt(numsPuntuacion[i].innerText)) {
        case 1:
            numsPuntuacion[i].innerHTML = "";
            numsPuntuacion[i].appendChild(document.createElement("img")).src = "img/unaEstrellas.svg";
            break;

        case 2:
            numsPuntuacion[i].innerHTML = "";
            numsPuntuacion[i].appendChild(document.createElement("img")).src = "img/dosEstrellas.svg";
            break;

        case 3:
            numsPuntuacion[i].innerHTML = "";
            numsPuntuacion[i].appendChild(document.createElement("img")).src = "img/tresEstrellas.svg";
            break;

        case 4:
            numsPuntuacion[i].innerHTML = "";
            numsPuntuacion[i].appendChild(document.createElement("img")).src = "img/cuatroEstrellas.svg";
            break;

        case 5:
            numsPuntuacion[i].innerHTML = "";
            numsPuntuacion[i].appendChild(document.createElement("img")).src = "img/cincoEstrellas.svg";
            break;

        default:
            numsPuntuacion[i].innerText = "mal";
    }
}


