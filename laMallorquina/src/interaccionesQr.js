// Obtener el pedido_id de la URL
const urlParams = new URLSearchParams(window.location.search);
const pedidoId = urlParams.get('pedido_id');

let pedidoContent = document.getElementById("general");
let titlePedido = document.getElementById("tituloPedido");
let precioTotal = document.getElementById("pTotal");

// Hacer la solicitud Fetch con el pedido_id
fetch(`http://localhost/laMallorquina/?controller=api&action=apiGetPedidoById&pedido_id=${pedidoId}`)
    .then(response => response.json())
    .then(pedidoData => {
        console.log(pedidoData);

        titlePedido.textContent += `#${pedidoId}:`; 

        let fechaPedido = document.createElement("div");
        fechaPedido.innerHTML = `
            <p>Fecha: ${pedidoData[0].fecha_pedido}</p>
            <hr>
        `;
        pedidoContent.appendChild(fechaPedido);

        pedidoData.forEach(item => {
            let productoElement = document.createElement("div");
            productoElement.innerHTML = `
                <div class="d-flex justify-content-between flex-wrap">
                    <p>${item.nombre_producto}</p>
                    <p>${item.cantidad} uds.</p>
                    <p>${item.precio_unidad} €</p>
                </div>
            `;
            pedidoContent.appendChild(productoElement);
            precioTotal.innerHTML = `
            <hr>
            <div class="d-flex justify-content-between flex-wrap">
                <p>Puntos gastados</p>
                <p>${item.puntos_usados}</p>
            </div>
            <hr>
            <div class="d-flex justify-content-between flex-wrap">
                <p>Propina</p>
                <p>${item.propina} €</p>
            </div>
            <hr>
            <p class="text-end"><b>TOTAL: ${pedidoData[0].precio_total} €</b></p>
            `;
        });
        
    })



