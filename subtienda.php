<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

// Conectar con MongoDB
$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new Client($uri);
$database = $client->gadgget;
$collection = $database->productos;

// Obtener el ID de la URL
if (!isset($_GET['id'])) {
    die("Error: Producto no encontrado.");
}

$id = $_GET['id'];

try {
    // Buscar el producto en la base de datos
    $producto = $collection->findOne(['_id' => new ObjectId($id)]);
    
    if (!$producto) {
        die("Error: Producto no encontrado.");
    }
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
    <h1><?= htmlspecialchars($producto['nombre']) ?></h1>
    <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
    <p><?= htmlspecialchars($producto['descripcion']) ?></p>
    <h3>Precio: $<?= number_format(floatval($producto['precio']), 2) ?></h3>
    <h4>Stock: <?= intval($producto['stock']) ?></h4>

    <!-- Volver a la tienda -->
    <a href="tienda.php">Volver a la tienda</a>
</body>
</html>
