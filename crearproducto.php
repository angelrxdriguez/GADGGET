<?php
session_start();
require 'vendor/autoload.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget; 
$collection = $database->productos; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $imagen = trim($_POST['imagen']);
    $stock = intval($_POST['stock']);
    $tipo = trim($_POST['tipo']);

    if (empty($nombre) || empty($descripcion) || empty($imagen) || $precio <= 0 || $stock < 0 || empty($tipo)) {
        echo "<script>alert('Por favor, complete todos los campos correctamente.'); window.location.href='admin.php';</script>";
        exit();
    }

    $nuevoProducto = [
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'precio' => $precio,
        'imagen' => $imagen,
        'stock' => $stock,
        'tipo' => $tipo  //tipo!!!
    ];

    $insertResult = $collection->insertOne($nuevoProducto);

    if ($insertResult->getInsertedCount() > 0) {
        echo "<script>alert('Producto añadido '); window.location.href='admproductos.php';</script>";
    } else {
        echo "<script>alert('Error al añadir el producto.'); window.location.href='admproductos.php';</script>";
    }
}
?>
