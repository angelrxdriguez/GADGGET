<?php
require 'veradmin.php';
//si el user inicio sesion
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="icon" type="image/png" href="fotos/enelpueblo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ballet:opsz@16..72&family=Lacquer&family=Oswald:wght@200..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="logos/gadget.jpg" alt="Logo" height="90" class="logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin.php">ADMINISTRADOR</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="admproductos.php">PRODUCTOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admstock.php">STOCK</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="admped.php">PEDIDOS</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="opciones">
        <a href="admproductos.php" class="enlaceopcion">
            <div class="opcion">
                <img src="ico/product.png" alt="" class="iconoopcion">
                <h1 class="h1opcion">PRODUCTOS</h1>
            </div>
        </a>
        <a href="admstock.php" class="enlaceopcion">
            <div class="opcion">
                <img src="ico/clipboard.png" alt="" class="iconoopcion">
                <h1 class="h1opcion">STOCK</h1>
            </div>
    </a>

    </div>
    <a href="admped.php" class="enlaceopcion">
        <div class="opcionp">
            <img src="ico/fast-delivery.png" alt="" class="iconoopcion">
            <h1 class="h1opcion">PEDIDO</h1>
        </div>
    </a>
    <footer class="text-center text-white" style="background-color: #000000">
        <div class="container">
            <section class="mt-5">
                <div class="row text-center d-flex justify-content-center pt-5">
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="home" class="text-white">Home</a>
                        </h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="discos.html" class="text-white">Discos</a>
                        </h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="conciertos.html" class="text-white">Conciertos</a>
                        </h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="contacto.html" class="text-white">Contacto</a>
                        </h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="login.html" class="text-white">SESIÓN</a>
                        </h6>
                    </div>
                </div>
            </section>
            <hr class="my-5" />
            <section class="mb-5">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <p>
                            Página web Prototipo de tienda funcional elaborada por Ángel Panadero Rodríguez. Estudiante
                            2º año Desarrollo de Aplicaciones Web.
                        </p>
                    </div>
                </div>
            </section>
            <section class="text-center mb-5">
                <a href="https://x.com/i/flow/login?redirect_after_login=%2Fjarfaiter_dice" class="text-white me-4">
                    <img src="iconos/twitter (1).png" alt="" class="iconofooter">
                </a>
                <a href="https://www.facebook.com/login/?next=https%3A%2F%2Fwww.facebook.com%2Fjarfaiter%2F%3Flocale%3Des_ES"
                    class="text-white me-4">
                    <img src="iconos/facebook (1).png" alt="" class="iconofooter">
                </a>
                <a href="https://www.youtube.com/channel/UCUCxEgrssyvszRfaLBmFxhA" class="text-white me-4">
                    <img src="iconos/youtube (1).png" alt="" class="iconofooter">
                </a>
            </section>
        </div>
        <div class="text-center p-3">
            © 2025 Copyright:
            <a class="text-white" href="contacto.html">GADGGET</a>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>