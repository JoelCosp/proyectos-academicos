  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estiloAccionesAdmin.css">
    <link rel="stylesheet" href="estiloRegistro.css">
    <link rel="stylesheet" href="estilos/estiloActualizarUsuario.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Panel de modificación del perfil</title>
</head>
<body>
    <h1 class="titulo mt-5">SU CUENTA</h1>
    <h2 class="subtitulo">Sus datos personales</h2>
    <section class="row">
        <div class="row p-0">
            <form class="d-flex justify-content-center align-items-center flex-column formularioUsuario" action="<?= URL ?>?controller=actualizarUsuario&action=procesarFormularioModificarUsuario" method="post">
                <input type="text" name="nombre" value="<?= $usuario->getNombre()?>" placeholder="<?= $usuario->getNombre()?>">
                <input type="text" name="apellido" value="<?= $usuario->getApellido()?>" placeholder="<?= $usuario->getApellido()?>">
                <input type="email" name="email" value="<?= $usuario->getEmail()?>" placeholder="<?= $usuario->getEmail()?>">
                <div class="inputsRadio">
                    <input type="radio" name="sr">
                        <label for="sr">Sr.</label>
                    <input type="radio" name="sra">
                        <label for="sra">Sra.</label>
                </div>
                <input type="password" name="contraseña" placeholder="Nueva contraseña">
                <input type="password" name="nuevaContraseña" value="<?= $usuario->getContraseña()?>" placeholder="Nueva contraseña">
                <input type="submit" name="btnActualizarDatos" value="ACTUALIZAR DATOS">
            </form>
        </div>
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