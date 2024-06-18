<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="estilos/estiloAccionesAdmin.css">-->
    <link rel="stylesheet" href="estilos/estiloActualizarUsuario.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Panel de creación de productos</title>
</head>
<body>
    <h2 class="subtitulo mt-5">Inserta un producto</h2>
    <section class="row">
        <div class="row p-0">
            <form class="d-flex justify-content-center align-items-center flex-column formularioUsuario" action="<?= URL ?>?controller=tablaAdmin&action=procesarFormularioInsertar" method="post">
                <input type="text" name="nombre" placeholder="Nombre">
                <input type="text" name="descripcion" placeholder="Descripción">
                <input type="text" name="precioUnitario" placeholder="Precio unitario">
                <input type="text" name="categoria" placeholder="Categoría">
                <input type="text" name="img" placeholder="Imagen">
                <input type="submit" name="btnInsertar" value="INSERTAR">
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