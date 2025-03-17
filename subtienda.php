<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new Client($uri);
$database = $client->gadgget;
$collection = $database->productos;

if (!isset($_GET['id'])) {
    die("Error: Producto no encontrado.");
}

$id = $_GET['id'];

try {
    $producto = $collection->findOne(['_id' => new ObjectId($id)]);
    
    if (!$producto) {
        die("Error: Producto no encontrado.");
    }

    $productosRelacionados = $collection->find([
        'tipo' => $producto['tipo'], 
        '_id' => ['$ne' => new ObjectId($id)] 
    ])->toArray();
    
} catch (Exception $e) {
    die("Error: ID no válido.");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDEX</title>
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
                <a class="nav-link" href="conciertos.html">CONTACTANOS</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="carrito.html">
                        <img src="ico/carrito-de-compras (1).png" alt="Carrito" height="35" class="nav-icon">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.html">
                        <img src="ico/acceso (2).png" alt="Sesion" height="35" class="nav-icon">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="contenedorsub">
    <div class="fototit">
        <h1 class="titprod"><?= htmlspecialchars($producto['nombre']) ?></h1>
            <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="cas" class="fotoprod">
            
        </div>
        <div class="datos">
        <h4 class="descripcionprod"><?= htmlspecialchars($producto['descripcion']) ?></h4>
           <div class="subdatos">
            <h3 class="precioprod"><?= number_format(floatval($producto['precio']), 2) ?></h3>
            <button type="submit" class="añadircarrito">Añadir Carrito</button>
        </div>
        </div>
</div>
<h1 class="relacionados">RELACIONADOS</h1>
<div class="productos">
    <?php if (!empty($productosRelacionados)): ?>
        <?php foreach ($productosRelacionados as $relacionado): ?>
            <a href="subtienda.php?id=<?= $relacionado['_id'] ?>" class="enlacesubtienda">
                <div class="card producto">
                    <img class="card-img-top" src="<?= htmlspecialchars($relacionado['imagen']) ?>" alt="<?= htmlspecialchars($relacionado['nombre']) ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($relacionado['nombre']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($relacionado['descripcion']) ?></p>
                        <h6 class="precio">$<?= number_format(floatval($relacionado['precio']), 2) ?></h6>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos relacionados.</p>
    <?php endif; ?>
</div>
</body>
</html>
