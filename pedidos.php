<?php
session_start();
require 'vendor/autoload.php';

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget;
$collection_usuarios = $database->usuarios;
$collection_pedidos = $database->pedidosAceptados;
$collection_productos = $database->productos;

if (!isset($_SESSION['usuario'])) {
    echo "<script>window.location.href='login.html';</script>";
    exit();
}

$nombre_usuario = $_SESSION['usuario']; 

$usuario = $collection_usuarios->findOne(['nombre' => $nombre_usuario]);

if (!$usuario) {
    echo "<script>alert('Usuario no encontrado.'); window.location.href='login.html';</script>";
    exit();
}

$pedidos = $collection_pedidos->find(['usuario' => $usuario['nombre']]);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pedidos</title>
    <link rel="icon" type="image/png" href="fotos/enelpueblo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ballet:opsz@16..72&family=Lacquer&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html">
            <img src="logos/gadget.jpg" alt="Logo" height="90" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">HOME</a>
            </li>
                <li class="nav-item"><a class="nav-link" href="tienda.php">TIENDA</a>
            </li>
                <li class="nav-item"><a class="nav-link" href="gadgget.php">GADGGET</a>
            </li>
                <li class="nav-item"><a class="nav-link active" href="pedidos.php">PEDIDOS</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="carrito.php">
                        <img src="ico/carrito-de-compras (1).png" alt="Carrito" height="35">
                    </a>
                </li>
                <li class="nav-item">
    <?php if ($usuario): ?>
        <a class="nav-link" href="usuario.php">
            <?= htmlspecialchars($usuario['nombre']); ?>
        </a>
    <?php else: ?>
        <a class="nav-link" href="login.php">
            <img src="ico/acceso (2).png" alt="Sesion" height="35" class="nav-icon">
        </a>
    <?php endif; ?>
</li>
            </ul>
        </div>
    </div>
</nav>

<h1 class="tit">Tus pedidos,<?= htmlspecialchars($usuario['nombre']); ?>:</h1>
<div class="contenedorpedidos">
    <?php foreach ($pedidos as $pedido): ?>
        <div class="pedido">
            <?php foreach ($pedido['productos'] as $producto): 
                $productoDatos = $collection_productos->findOne(['_id' => new MongoDB\BSON\ObjectId($producto['producto_id'])]);
            ?>
                <div class="datos">
                    <img src="<?= $productoDatos['imagen'] ?>" class="fotoped" alt="">
                    <h3 class="titped"><?= $productoDatos['nombre'] ?></h3>
                    <h3 class="cantidad">Cantidad: <?= $producto['cantidad'] ?></h3>
                    <h3 class=""><?= $productoDatos['precio'] ?>€</h3>
                    <h3 class="precio"><?= $productoDatos['precio'] * $producto['cantidad'] ?>€</h3>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
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
              <a href="tienda.php" class="text-white">Tienda</a>
            </h6>
          </div>
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="gadgget.php" class="text-white">Gadgget</a>
            </h6>
          </div>
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="pedidos.php" class="text-white">Pedidos</a>
            </h6>
          </div>
        </div>
      </section>
      <hr class="my-5" />
      <section class="mb-5">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8">
            <p>
              Página web Prototipo de tienda funcional elaborada por Ángel Panadero Rodríguez. Estudiante 2º año Desarrollo de Aplicaciones Web.
            </p>
          </div>
        </div>
      </section>
      <section class="text-center mb-5">
        <a href="https://x.com/i/flow/login?redirect_after_login=%2Fjarfaiter_dice" class="text-white ">
          <img src="ico/twitter.png" alt="" class="iconofooter">
        </a>
        <a href="https://www.facebook.com/login/?next=https%3A%2F%2Fwww.facebook.com%2Fjarfaiter%2F%3Flocale%3Des_ES" class="text-white ">
            <img src="ico/facebook.png" alt="" class="iconofooter">
        </a>
        <a href="https://www.youtube.com/channel/UCUCxEgrssyvszRfaLBmFxhA" class="text-white ">
            <img src="ico/youtube (1).png" alt="" class="iconofooter">
        </a>
      </section>
    </div>
    <div
         class="text-center p-3"
         >
      © 2025 Copyright:
      <a class="text-white" href=""
         >GADGGET</a   
        >
    </div>
  </footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="src/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
