<?php 
include_once 'modelo/reseñasDAO.php';
include_once 'controlador/apiControlador.php';  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloReseñas.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Mallorquina | Panel de control</title>
</head>
<body>

    <section class="mt-5">
        <div class="tituloForm">
            <h2 id="titulo">Valoraciones</h2>
            <button id="formularioEstrellas">Filtrar por: ▼</button>
        </div>
        <div id="reseñasContainer" class="row"></div>
    </section>

    

    <!--SCRIPTS BOOTSTRAP-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    
    <script src="src/api.js"></script>
    <script src="src/interacciones.js"></script>
</body>
</html>
