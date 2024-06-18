let btnFiltrarProductos = document.getElementById("btnFilters");
let checkEnsalada = document.getElementById("checkEnsaladas");
let checkSopa = document.getElementById("checkSopas");
let checkCrema = document.getElementById("checkCremas");
let checkBoxes = document.getElementsByClassName("cBox");
let seccionesProductos = document.getElementsByClassName("productosJs");
let divsPhp = document.getElementsByClassName("seccionesPhp");
let titulos = document.getElementsByTagName("h1");
let tituloBorrar = document.getElementById("tituloInvisible");
tituloBorrar.style.display = "none";

let productosObtenidos = [];
let grupoProductos = document.getElementById("productosObten");

// Llamar a la API para obtener PRODUCTOS con fetch
fetch("http://localhost/laMallorquina/?controller=api&action=apiObtenerProductos")
    .then(response => response.json())
    .then(productosGuardados => {
        productosObtenidos = productosGuardados;
    });

btnFiltrarProductos.addEventListener("click", () => {
    grupoProductos.innerHTML = "";
    tituloBorrar.classList.remove("tituloBorrar");

    // Quitar los divs impresos con php
    for (let i = 0; i < divsPhp.length; i++) {
        divsPhp[i].style.display = "none";
    }

    // Quitar los titulos
    for (let i = 0; i < titulos.length; i++) {
        titulos[i].style.display = "none";
    }

    // Filtrar productos por categorías seleccionadas
    let pEscogido = [];
    for (let i = 0; i < checkBoxes.length; i++) {
        if (checkBoxes[i].checked) {
            const productosCategoria = productosObtenidos.filter(e => e.categoria_id === i + 1);
            pEscogido = pEscogido.concat(productosCategoria);
        }
    }

    // Por cada elemento, se imprime el contenedor que se muestra en la vista
    pEscogido.forEach(e => {
        let productoArticulo = document.createElement('article');
        productoArticulo.classList.add('col-12', 'col-md-6', 'col-lg-3', 'd-flex', 'justify-content-center', 'my-3', 'px-0', 'flex-column', 'align-items-center', 'tarjeta');
        productoArticulo.innerHTML = `
            <img class="imgProducto" src="img/${e.img}.jpg" alt="Producto de la carta">
            <p>${e.nombre_producto}<br></p>
            <p><b>${e.precio_unidad} €</b></p>
            <div class="row d-flex w-100 acciones">
                <div class="col-6 d-flex p-0 justify-content-center accion">
                    <form class="w-100" action="" method="post">
                        <input id="btnLupa" type="submit" name="infoProducto" value="">
                    </form>
                </div>
                <div class="col-6 d-flex p-0 justify-content-center accion">
                    <form class="w-100" action="?controller=producto&action=añadirProductoArray" method="post">
                        <input id="btnCesta" type="submit" name="añadirCarrito" value="${e.producto_id}">
                    </form>
                </div>
            </div>
        `;
        grupoProductos.appendChild(productoArticulo);
    });
});
