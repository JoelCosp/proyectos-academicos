<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloIniciarSesion.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Inicio de sesión</title>
</head>
<body>
    <div class="row mx-4 mt-5">
        <h2 class="titulo">Iniciar sesión con su cuenta</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-3">
                <p class="texto">¡Inicie sesión!</p>
                <form action="<?= URL ?>?controller=inicioSesion&action=startSession" method="post" id="formularioIniciar">
                    <input type="email" name="correo" placeholder="Dirección de correo electrónico">
                    <input type="password" name="contraseña" placeholder="Contraseña">
                    <p class="texto">¿Olvidó su contraseña?</p>
                    <input type="submit" name="iniciarSesion" value="INICIAR SESIÓN">
                </form>
                <div class="centrado">
                    <form action="" method="post">
                        <hr>
                        <a href="<?= URL ?>?controller=registro&action=index"><p class="texto">¿No tiene una cuenta? Cree una aquí</p></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</body>
</html>