<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new Client($uri);
$database = $client->gadgget;
$pedidosCollection = $database->pedidos;
$productosCollection = $database->productos;

if (!isset($_POST['pedido_id'])) {
    echo "<script>alert('ID de pedido no recibido.'); window.location.href='admped.php';</script>";
    exit();
}

$pedidoId = $_POST['pedido_id']; // Obtener el ID del pedido

// Buscar el pedido en la base de datos
$pedido = $pedidosCollection->findOne(['_id' => new ObjectId($pedidoId)]);

if (!$pedido) {
    echo "<script>alert('Pedido no encontrado.'); window.location.href='admped.php';</script>";
    exit();
}

// Devolver el stock de los productos del pedido
foreach ($pedido['productos'] as $producto) {
    $productoId = new ObjectId($producto['producto_id']);
    $cantidad = $producto['cantidad'];

    // Aumentar el stock en la base de datos
    $productosCollection->updateOne(
        ['_id' => $productoId],
        ['$inc' => ['stock' => $cantidad]] // Sumar la cantidad al stock
    );
}

// Eliminar el pedido de la colección
$pedidosCollection->deleteOne(['_id' => new ObjectId($pedidoId)]);

echo "<script>alert('Pedido cancelado y stock restablecido.'); window.location.href='admped.php';</script>";
?>
