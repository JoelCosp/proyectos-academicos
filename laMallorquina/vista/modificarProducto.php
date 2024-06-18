  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloActualizarUsuario.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Panel de modificación de productos</title>
</head>
<body>

    <h2 class="subtitulo mt-5">Actualiza el producto</h2>
    <section class="row">
        <div class="row p-0">
            <form class="d-flex justify-content-center align-items-center flex-column formularioUsuario" action="<?= URL ?>?controller=tablaAdmin&action=procesarFormularioModificar" method="post">
                <input type="text" name="nombre" value="<?= $productoUpdate->getNombre() ?>" placeholder="Nombre">
                <input type="text" name="descripcion" value="<?= $productoUpdate->getDescripcion() ?>" placeholder="Descripción">
                <input type="text" name="precioUnitario" value="<?= $productoUpdate->getPrecioUnidad() ?>" placeholder="Precio unitario">
                <input type="text" name="categoria" value="<?= $productoUpdate->getCategoriaId() ?>" placeholder="Categoría">
                <input type="text" name="img" value="<?= $productoUpdate->getImg() ?>" placeholder="Imagen">
                <input type="submit" name="btnActualizar" value="ACTUALIZAR">
                <input type="hidden" name="escondidoModificar" value="<?= $productoUpdate->getProductoId() ?>">
            </form>
        </div>
    </section>
    <section class="seccionLinks d-flex">
        <a href="<?php URL ?>?controller=tablaAdmin&action=indexPanelProductosAdmin">◄ Volver</a>
        <a href="<?php URL ?>?controller=cuerpo">🏠 Inicio</a>
    </section>

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</body>
</html>