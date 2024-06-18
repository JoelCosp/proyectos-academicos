<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloRegistro.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Registro</title>
</head>
<body>
    <div class="row mx-4 mt-5">
        <h2 class="titulo">Crear una cuenta</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-3">
                <a id="linkLogin" href="<?= URL ?>?controller=inicioSesion&action=index"><p class="texto">¿Ya tiene una cuenta? ¡Inicie sesión!</p></a>
                <form action="<?= URL ?>?controller=registro&action=registrar" method="post" id="formularioIniciar">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="text" name="apellido" placeholder="Apellido" required>
                    <input type="email" name="email" placeholder="Dirección de correo electrónico" required>
                    <input type="radio" name="sr">
                    <label for="sr">Sr.</label>
                    <input type="radio" name="sra">
                    <label for="sra">Sra.</label>
                    <input type="password" name="contraseña" placeholder="Contraseña" required>
                    <span class="d-flex align-top infoFinal">
                        <input type="radio" name="suscribirse" required>
                        <label for="suscribirse">Suscribirse a nuestro boletín de noticias
                            Puede darse de baja en cualquier momento. Para ello, consulte nuestra información de contacto en el aviso legal.
                        </label>
                    </span>
                    <span class="d-flex align-top infoFinal">
                        <input type="radio" name="tratoDatos" required>
                        <label for="tratoDatos">He leído y acepto la información básica sobre el tratamiento de datos
                        </label>
                    </span>
                    <input class="mt-5" type="submit" name="btnRegistrar" value="GUARDAR">
                </form>
            </div>
        </div>
    </div>

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</body>
</html>
