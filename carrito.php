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

// Verificar que el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Debes iniciar sesión para ver el carrito.'); window.location.href='login.html';</script>";
    exit();
}

$usuarioNombre = $_SESSION['usuario'];

// Obtener la información del usuario y su cesta
$usuario = $usuariosCollection->findOne(['nombre' => $usuarioNombre]);

if (!$usuario || !isset($usuario['cesta']) || empty($usuario['cesta'])) {
    $productos = []; // Carrito vacío
} else {
    // Buscar los productos en la base de datos con los IDs guardados en la cesta
    $idsCesta = iterator_to_array($usuario['cesta']); // Convertir BSONArray a array PHP

    $productos = $productosCollection->find([
        '_id' => ['$in' => array_map(fn($id) => new ObjectId($id), $idsCesta)]
    ])->toArray();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CESTA</title>
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
        <a class="navbar-brand" href="index.php">
            <img src="logos/gadget.jpg" alt="Logo" height="90" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
                <li class="nav-item"><a class="nav-link active" href="tienda.php">TIENDA</a></li>
                <li class="nav-item"><a class="nav-link" href="carrito.php">
                    <img src="ico/carrito-de-compras (1).png" alt="Carrito" height="35">
                </a></li>
                <li class="nav-item"><a class="nav-link" href="login.html">
                    <img src="ico/acceso (2).png" alt="Sesion" height="35">
                </a></li>
            </ul>
        </div>
    </div>
</nav>

<h1>ESTE ES TU CARRITO</h1>

<div class="productos">
    <?php if (empty($productos)): ?>
        <p>No hay productos en el carrito.</p>
    <?php else: ?>
        <?php foreach ($productos as $producto): ?>
            <div class="card producto">
                <img class="card-img-top" src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                <div class="card-body text-center">
                    <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                    <p class="card-text text-muted"><?= htmlspecialchars($producto['descripcion']) ?></p>
                    <h6 class="precio">$<?= number_format(floatval($producto['precio']), 2) ?></h6>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
