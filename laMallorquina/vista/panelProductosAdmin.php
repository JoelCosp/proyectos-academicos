<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloPanelesAdmin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Panel de productos</title>
</head>
<body>
    <h2 class="titulo mt-5">Panel de productos</h2>
    <section class="seccionGeneral row d-flex justify-content-center">
        <div class="row p-0">
        <div class="table-responsive container-fluid">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO UNITARIO</th>
                <th>CATEGORIA_ID</th>
                <th>IMÁGENES</th>
                <th>ACCIONES</th>
            </tr>
            <?php
                foreach ($products as $product) {      
            ?>
            <tr>
                <td><?= $product->getProductoId()?></td>
                <td><?= $product->getNombre()?></td>
                <td><?= $product->getDescripcion()?></td>
                <td><?= $product->getPrecioUnidad()?> €</td>
                <td><?= $product->getCategoriaId()?></td>
                <td><?= $product->getImg()?>.jpg</td>
                <td class="btnsAcciones d-flex flex-wrap">
                    <form action="<?= URL ?>?controller=tablaAdmin&action=indexModificar" method="post">
                        <input type="hidden" name="escondidoModificar" value="<?= $product->getProductoId()?>">
                        <input type="submit" name="modificar" value="MODIFICAR">
                    </form>
                    <form action="<?= URL ?>?controller=tablaAdmin&action=eliminarProducto" method="post">
                        <input type="hidden" name="escondido" value="<?= $product->getProductoId()?>">
                        <input type="submit" name="eliminar" value="ELIMINAR">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
        <form action="<?= URL ?>?controller=tablaAdmin&action=indexAñadir" method="post">
            <input type="submit" name="botonAñadir" value="AÑADIR">
        </form>
    </div>
            </div>
        </section>
        <section class="seccionLinks d-flex">
            <a href="<?php URL ?>?controller=tablaAdmin">◄ Volver</a>
            <a href="<?php URL ?>?controller=cuerpo">🏠 Inicio</a>
        </section>

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</body>
</html>
