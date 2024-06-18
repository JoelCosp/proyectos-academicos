<?php include("controlador/cantidadesControlador.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/mLogo.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloHeaderSup.css">
</head>
<body>
  <!--LINEA GRIS PROPAGANDA SUPERIOR-->
  <div class="container-fluid px-0 cabecera">
    <div class="propaganda">
      <p>
        <b>ENVÍO GRATIS A PARTIR DE 49,90€. CAMBIOS Y DEVOLUCIONES GRATIS.*</b>
      </p>
    </div> 
  </div>

  <!--MENU INFO SUPERIOR IZQUIERDA-->
  <div id="desaparecer" class="row mt-4 filaMenuInfo">
    <div class="col-12 col-md-4 col-lg-4 d-flex align-items-start infoIzquierda">
      <ul class="list-group list-group-horizontal-sm primera lista">
        <li>ATT. AL CLIENTE <b> 673 482 995</b></li>
        <li>CONTACTO</li>
        <li>TARJETA REGALO</li>
        <li id="sinBordeDerecho">TIENDAS</li>
      </ul>
    </div>

  <!--LOGO CENTRAL-->
  <div id="desaparecer" class="col-12 col-md-4 col-lg-4 d-flex align-items-center justify-content-center imgLogo">
    <a href="<?php URL ?>?controller=cuerpo"><img id="imgLogoPagina" class="img-fluid" src="img/logoMallorquina.svg" alt="Logo de la Mallorquina"></a>
  </div>

    <!--MENU INFO SUPERIOR DERECHA-->
    <div id="desaparecer" class="col-12 col-md-4 col-lg-4 d-flex align-items-end justify-content-start flex-column infoDerecha">
      <ul class="d-flex justify-content-end list-group list-group-horizontal-sm lista">
        <!--Si existe la variable de session accesoAdmin y es igual a true, se muestra el boton del administrador-->
        <?php if (isset($_SESSION['accesoAdmin']) && $_SESSION['accesoAdmin'] == true) : ?>
              <li>
                <a href="<?php URL ?>?controller=tablaAdmin">
                  <img src="img/logoEditar.svg" alt="Botón del administrador">
                </a>
              </li> 
        <?php endif; ?>
        <li>ES / CA / EN</li>
        <!--Si existe la vvariable de session idCliente, se muestran los siguientes li-->
        <?php if (isset($_SESSION['idCliente'])) : ?>
            <li id="linkSesionHeader">
                <a href="<?php URL ?>?controller=panelControl">BIENVENIDO</a>
            </li>
            <li class="iconoAccion">
              <a href="<?php URL ?>?controller=actualizarUsuario&action=index">
                <img src="img/logoUsuario.svg" alt="Logo usuario">
              </a>
            </li>
        <!--Por contra, se muestran estos-->
        <?php else : ?>
            <li id="linkSesionHeader">
                <a href="<?= URL ?>?controller=inicioSesion&action=index">INICIAR SESIÓN</a>
            </li>
            <li class="iconoAccion">
                <img src="img/logoUsuario.svg" alt="Logo usuario">
            </li>
        <?php endif; ?>
        <li id="sinBordeIzquierdo"><a id="linkCarrito" href="<?php URL ?>?controller=carrito">CESTA DE LA COMPRA</a></li>
        <li class="iconoAccion">
          <div class="packCarrito">
            <img class="imgLinks" src="img/logoCarrito.svg" alt="Logo carrito">
            <p><?= $cantidad ?></p>
          </div>
        </li>
      </ul>
      <form class="buscador pt-3" action="" method="post">
        <input type="search" name="buscador" placeholder="BUSCAR">
        <button>
          <img src="img/logoLupa.svg" alt="Logo lupa del buscador">
        </button>
      </form>
    </div>
  </div>

  <!--MENÚ DE LINKS-->
  <div id="desaparecer" class="row">
    <ul class="nav my-3 justify-content-center">
      <li class="nav-item">
        <a class="nav-link active" href="<?php URL ?>?controller=cuerpo">RESTAURANTE</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php URL ?>?controller=producto">LA CARTA</a>
      </li>
    </ul>
  </div>

  <!--NAVEGADOR PARA TLF-->
  <nav id="movil" class="navbar navbar-expand-lg bg-white mt-5 mb-4">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <?php if (isset($_SESSION['accesoAdmin']) && $_SESSION['accesoAdmin'] == true) : ?>
            <li><a href="<?= URL ?>?controller=tablaAdmin"> <img src='img/logoEditar.svg' alt="Botón del administrador"></a></li>
          <?php endif; ?>

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?php URL ?>?controller=cuerpo">RESTAURANTE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="<?php URL ?>?controller=producto">LA CARTA</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="<?php URL ?>?controller=carrito" aria-disabled="true">CESTA DE LA COMPRA</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">BUSCAR</button>
        </form>
      </div>
    </div>
  </nav>
</body>
</html>