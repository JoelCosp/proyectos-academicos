<?php
include_once 'controlador/apiControlador.php';  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos/estiloCarrito.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloAgradecimientos.css">
    <link rel="stylesheet" href="estilos/estiloNotie.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/notie/dist/notie.min.css">
    <title>La Mallorquina | Déjanos tú opinión</title>
</head>
<body>

    <?php
      // Imprimir img de la API
      apiControlador::cogerIdApi();
    ?>
    
    <section class="d-flex justify-content-center align-items-center py-5">
        <article id="articuloQr" class="d-flex justify-content-center align-items-center flex-column py-4 articuloQr">
            <div class="qr">
                <img src="img/image.png" alt="">
            </div>
            <h1>Grácias por su compra!</h1>
            <h2>Para más información sobre el pedido, escanee el siguiente código.</h2>
            <div class="botones d-flex align-items-center">
                <a href="<?php URL ?>?controller=carrito">
                    <button>Volver</button>
                </a>
                <!-- Button trigger modal -->
                <button type="button" id="btnDejarOpinion" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Deja tú opinión</button>
            </div>
            <a id="enlaceReviews" href="<?php URL ?>?controller=reseñas">Consulta las reseñas</a>
        </article>
    </section>
    
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <div class="infoUsuario d-flex align-items-center">
                <?php if (isset($_SESSION['idCliente'])) : ?>
                  <form action="">
                    <input type="hidden" id="numIdCliente" value="<?= $_SESSION['idCliente'] ?>">
                  </form>
                <?php endif; ?>
                <img src="img/panel1.svg" alt="Imagen por defecto del usuario">
                <h3 id="nombre"></h3>
                <h3 id="apellido"></h3>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="estrellasSeleccionar" class="d-flex justify-content-center flex-wrap"></div>
            <form action="">
                <!--<input type="text" placeholder="Cuéntanos tú experiencia">-->
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Cuéntanos tú experiencia:</label>
                  <textarea class="form-control" id="txtReviewInsertar"></textarea>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" id="btnEnviarDatos" class="btn btn-primary" data-bs-dismiss="modal">Enviar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="src/api.js"></script>
    <script src="src/interaccionesQr.js"></script>
    <script src="src/apiInsertarReview.js"></script>
    <script src="https://unpkg.com/notie"></script>
</body>
</html>