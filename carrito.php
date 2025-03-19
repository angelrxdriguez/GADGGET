<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new Client($uri);
$database = $client->gadgget;
$usuariosCollection = $database->usuarios;
$productosCollection = $database->productos;

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Debes iniciar sesión para ver el carrito.'); window.location.href='login.html';</script>";
    exit();
}

$usuarioNombre = $_SESSION['usuario'];
$usuario = $usuariosCollection->findOne(['nombre' => $usuarioNombre]);

if (!$usuario || !isset($usuario['cesta']) || empty($usuario['cesta'])) {
    $productos = [];
} else {
    // Obtener IDs de los productos en la cesta
    $cesta = (array) $usuario['cesta']; // Convertimos BSONArray a un array PHP
    $productoIds = array_map(fn($item) => new ObjectId($item['producto_id']), $cesta);
    

    // Buscar productos en la base de datos
    $productosCursor = $productosCollection->find(['_id' => ['$in' => $productoIds]]);
    $productos = iterator_to_array($productosCursor);

    // Agregar la cantidad de cada producto
    foreach ($productos as $producto) {
        foreach ($usuario['cesta'] as $item) {
            if ($item['producto_id'] == (string)$producto['_id']) {
                $producto['cantidad'] = $item['cantidad'];
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
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

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">HOME</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link active" href="tienda.php">TIENDA</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="conciertos.html">GADGGET</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pedidos.php">PEDIDOS</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="carrito.php">
                        <img src="ico/carrito-de-compras (1).png" alt="Carrito" height="35" class="nav-icon">
                    </a>
                </li>
                <li class="nav-item">
    <?php if ($usuario): ?>
        <a class="nav-link" href="usuario.php">
            <?= htmlspecialchars($usuario['nombre']); ?>
        </a>
    <?php else: ?>
        <a class="nav-link" href="login.html">
            <img src="ico/acceso (2).png" alt="Sesion" height="35" class="nav-icon">
        </a>
    <?php endif; ?>
</li>
            </ul>
        </div>
    </div>
</nav>
<h1 class="carrito">CESTA</h1>

<div class="contenedorcesta">
    <?php if (empty($productos)): ?>
        <p class="np">No hay productos en el carrito <a href="tienda.php" class="npa">!Echa un Vistazo!</a></p>
    <?php else: ?>
        <?php foreach ($productos as $producto): ?>
            <div class="cesta">
                <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="fotocesta">
                <h3 class="titcesta"><?= htmlspecialchars($producto['nombre']) ?></h3>
                <p class="cantidadcesta">Cantidad: <?= $producto['cantidad'] ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<form action="comprar.php" method="POST">
    <input type="hidden" name="id" value="<?= $producto['_id'] ?>">
<button type="submit" class="btn comprar">COMPRAR</button>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
