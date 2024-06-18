<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estiloAccionesAdmin.css">
    <link rel="stylesheet" href="estiloRegistro.css">
    <link rel="stylesheet" href="estilos/estiloActualizarUsuario.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Panel de creación de usuarios</title>
</head>
<body>
    <h2 class="subtitulo  mt-5">Crear nuevo usuario</h2>
    <section class="row">
        <div class="row p-0">
            <form class="d-flex justify-content-center align-items-center flex-column formularioUsuario" action="<?= URL ?>?controller=tablaAdmin&action=crearUsuario" method="post">
                <input type="text" name="nombre" placeholder="Nombre">
                <input type="text" name="apellido" placeholder="Apellido">
                <input type="email" name="email" placeholder="Correo electrónico">
                <input type="text" name="rol" placeholder="Rol">
                <div class="inputsRadio">
                    <input type="radio" name="sr">
                        <label for="sr">Sr.</label>
                    <input type="radio" name="sra">
                        <label for="sra">Sra.</label>
                </div>
                <input type="password" name="contraseña" placeholder="Contraseña">
                <input type="submit" name="btnCrearUsuario" value="AÑADIR USUARIO">
            </form>
        </div>
    </section>
    <section class="seccionLinks d-flex">
        <a href="<?php URL ?>?controller=tablaAdmin&action=indexPanelUsuariosAdmin">◄ Volver a su cuenta</a>
        <a href="<?php URL ?>?controller=cuerpo">🏠 Inicio</a>
    </section>

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</body>
</html>