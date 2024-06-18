let cajaBox = document.getElementById("siPropina");
let cajaPuntos = document.getElementById("dejarPuntos");
let numsPuntos = document.getElementById("contadorPuntos");
let numsPropinas = document.getElementById("contadorPropina");
let btnConfirmCompra = document.getElementById("inputInsertarPedido");
let btnAplicarPuntos = document.getElementById("btnAplicar");

let idCliente = document.getElementById("idClienteActivo").value;
let vTotalInicial = parseFloat(document.getElementById("vTotalEscondido").value); // Precio total inicial
let vTotal = vTotalInicial; // Precio total actualizado en la sesión
let puntosUser;
let txtPuntos = document.getElementById("puntosRellenar");
let escondidoPropinas = document.getElementById("cantidadPropinaAlmacenar");

// Mostrar el input de las propinas
cajaBox.addEventListener("click", () => {
    if (cajaBox.checked) {
        numsPropinas.style.display = "block";
        numsPropinas.disabled = false;
        numsPropinas.value = 3;
    } else {
        numsPropinas.style.display = "none";
        numsPropinas.disabled = true;
        numsPropinas.value = 0;
    }
    actualizarPrecioTotal();
    actualizarPTHidden();
});

// Mostrar el input de los puntos
cajaPuntos.addEventListener("click", () => {
    if (cajaPuntos.checked) {
        numsPuntos.style.display = "block";
        numsPuntos.disabled = false;
    } else {
        numsPuntos.style.display = "none";
        numsPuntos.value = 0;
        numsPuntos.disabled = true;
        actualizarPrecioTotal(); // Llamar a la función para que el precio total vuelva al inicial
        actualizarPTHidden();
    }
});

// Obtener puntos del ususario
fetch(`http://localhost/laMallorquina/?controller=api&action=apiObtenerPuntosUsuario&id=${idCliente}`)
    .then(response => response.json())
    .then(puntosData => {
        infoObtenida = puntosData;
        puntosData.forEach((objs) => {
            txtPuntos.innerHTML += infoObtenida[0].puntos;
            puntosUser = infoObtenida[0].puntos;

            // Verificar si txtPuntos.innerHTML es un número válido antes de asignar el máximo
            if (!isNaN(parseInt(txtPuntos.innerHTML))) {
                numsPuntos.max = parseInt(txtPuntos.innerHTML);
            } else {
                // Manejar el caso en el que txtPuntos.innerHTML no es un número válido
                console.error("Error: El valor de txtPuntos no es un número válido.");
            }
        });
});

escondidoPropinas.value = vTotalInicial;

// Cada vez que se modifica el valor de los puntos, se ejecutan las siguientes funciones
numsPuntos.addEventListener("input", () => {
    actualizarPrecioTotal();
    actualizarPTHidden();
});

// Cuando se modifica la propina, se aplica el siguiente calculo
numsPropinas.addEventListener("input", () => {
    let propinaPorcentaje = parseFloat(numsPropinas.value) || 0;
    let propinaEnEuros = (vTotalInicial * propinaPorcentaje) / 100;

    // toFixed para fijar la cantidad de decimales y evitar redondeo hacia arriba
    escondidoPropinas.value = propinaEnEuros.toFixed(2);

    actualizarPrecioTotal();
    actualizarPTHidden();
});

let pTotalInsert = document.getElementById("vPrecioTotal");

// Funcion para calcular el precio total del pedido
function actualizarPrecioTotal() {
    let puntos = parseFloat(numsPuntos.value) || 0;
    let propina = parseFloat(numsPropinas.value) || 0;

    let puntosEnEuros = (puntos / 100); // Conversión de puntos a euros
    let propinaEnEuros = vTotalInicial * (propina / 100);

    let nuevoTotal = vTotalInicial - puntosEnEuros + propinaEnEuros;
    document.getElementById("vPrecioTotal").innerHTML = nuevoTotal.toFixed(2) + " €";
    vTotal = nuevoTotal; // Actualizar la variable global con el nuevo precio total
}

// Funcion para actualizar el valor del input hidden del precio total
function actualizarPTHidden() {
    document.getElementById("pTinsertar").value = vTotal.toFixed(2); // Actualizar el valor del campo pTHidden
    document.getElementById("points").value = numsPuntos.value;
}

// ENVIAR PUNTOS Y PROPINA EN UN MISMO CLICK
btnConfirmCompra.addEventListener("click", () => {  
    // Actualizar pTHidden con el valor total actualizado
    actualizarPTHidden();
    
    // Actualizar escondidoPropinas con el valor de propina actualizado
    if (cajaBox.checked) {
        let propinaPorcentaje = parseFloat(numsPropinas.value) || 0;
        let propinaEnEuros = (vTotalInicial * propinaPorcentaje) / 100;
        escondidoPropinas.value = propinaEnEuros.toFixed(2);
    } else {
        escondidoPropinas.value = 0;
    }

    let puntosRestar = numsPuntos.value;
    let puntosSumar = parseInt(vTotal) * 100;

    // Enviamos los datos a la api
    fetch(`http://localhost/laMallorquina/?controller=api&action=apiActualizarPuntosPropinas&puntosRestar=${puntosRestar}&puntosSumar=${puntosSumar}&id=${idCliente}`, {
        method: 'POST',
        body: JSON.stringify({
            puntosRestar: puntosRestar,
            puntosSumar: puntosSumar,
            cliente_id: idCliente
        }),
        headers: {
            'Content-Type': 'application/json; charset=UTF-8',
        }
    }).then(response => response.json())
        .then(json => console.log(json))
        .catch(err => console.log(err));
});
