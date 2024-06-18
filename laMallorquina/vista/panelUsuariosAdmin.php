<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloPanelesAdmin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Panel de usuarios</title>
</head>
<body>
    <h2 class="titulo mt-5">Panel de usuarios</h2>
    <section class="seccionGeneral row d-flex justify-content-center">
        <div class="row p-0">
            <div class="table-responsive container-fluid">
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>CORREO</th>
                        <th>ROL</th>
                        <th>GÉNERO</th>
                        <th>CONTRASEÑA</th>
                        <th>ACCIONES</th>
                    </tr>
                    <?php
                        foreach ($usuarios as $usuario) {
                    ?>
                    <tr>
                        <td><?= $usuario->getClienteId()?></td>
                        <td><?= $usuario->getNombre()?></td>
                        <td><?= $usuario->getApellido()?></td>
                        <td><?= $usuario->getEmail()?></td>
                        <td><?= $usuario->getRol()?></td>
                        <td><?= $usuario->getGenero()?></td>
                        <td><?= $usuario->getContraseña()?></td>
                        <td class="btnsAcciones d-flex flex-wrap">
                            <form action="<?= URL ?>?controller=tablaAdmin&action=indexModificarUsuario" method="post">
                                <input type="hidden" name="escondidoModificarUsuario" value="<?= $usuario->getClienteId()?>">
                                <input type="submit" name="modificarUsuario" value="MODIFICAR">
                            </form>
                            <form action="<?= URL ?>?controller=tablaAdmin&action=eliminarUsuario" method="post">
                                <input type="hidden" name="escondidoUsuario" value="<?= $usuario->getClienteId()?>">
                                <input type="submit" name="eliminarUsuario" value="ELIMINAR">
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                <form action="<?= URL ?>?controller=tablaAdmin&action=indexAñadirUsuario" method="post">
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
