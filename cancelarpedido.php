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

$pedidoId = $_POST['pedido_id']; 

$pedido = $pedidosCollection->findOne(['_id' => new ObjectId($pedidoId)]);

if (!$pedido) {
    echo "<script>alert('no encuentra'); window.location.href='admped.php';</script>";
    exit();
}

foreach ($pedido['productos'] as $producto) {//==$pedido as $pedidos si sacas coleccion pedidos ???¿
    $productoId = new ObjectId($producto['producto_id']);
    $cantidad = $producto['cantidad'];

//mete stock
    $productosCollection->updateOne(
        ['_id' => $productoId],
        ['$inc' => ['stock' => $cantidad]] // Sumar la cantidad al stock
    );
}

$pedidosCollection->deleteOne(['_id' => new ObjectId($pedidoId)]);

echo "<script>alert('Pedido cancelado y stock restablecido.'); window.location.href='admped.php';</script>";
?>
