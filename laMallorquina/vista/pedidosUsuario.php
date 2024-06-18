<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="estilos/estiloTablaAdmin.css">-->
    <link rel="stylesheet" href="estilos/estiloPedidosUsuarios.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Historial de pedidos</title>
</head>
<body>
    <h1 class="titulo mt-5">SU CUENTA</h1>
    <h2 class="subtitulo">Historial de pedidos</h2>
    <section class="seccionGeneral row d-flex justify-content-center">
        <div class="row p-0">
            <!--Si la variable misPedidos esta vacia, se imprime el siguiente div-->
            <?php if (empty($misPedidos)) : ?>
                <div class="sinPedidos">
                    <img src="img/logoAlerta.svg" alt="Logo alerta">
                    <p>No ha realizado ningún pedido.</p>
                </div> 
            <!--Si no, se imprime el siguiente div-->
            <?php else : ?>
                <div class="table-responsive container-fluid">
                    <table class="table table-hover">
                        <tr>
                            <th>PEDIDO ID</th>
                            <th>FECHA</th>
                            <th>ESTADO</th>
                            <th>PRECIO TOTAL</th>
                        </tr>
                        <?php
                            foreach ($misPedidos as $miPedido) {      
                        ?>
                        <tr>
                            <td><?= $miPedido->getPedidoId()?></td>
                            <td><?= $miPedido->getFecha()?></td>
                            <td><?= $miPedido->getEstado()?></td>
                            <td><?= $miPedido->getPrecioTotal()?> €</td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <h6>Estos son los pedidos que ha realizado desde que creó su cuenta</h6>
    </section>
    <section class="seccionLinks d-flex">
        <a href="<?php URL ?>?controller=panelControl">◄ Volver a su cuenta</a>
        <a href="<?php URL ?>?controller=cuerpo">🏠 Inicio</a>
    </section>

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</body>
</html>
