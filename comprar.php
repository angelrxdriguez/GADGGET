<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new Client($uri);
$database = $client->gadgget;
$usuariosCollection = $database->usuarios;
$pedidosCollection = $database->pedidos;

if (!isset($_SESSION['usuario'])) {
    echo "<script>window.location.href='login.html';</script>";
    exit();
}

$usuarioNombre = $_SESSION['usuario'];

$usuario = $usuariosCollection->findOne(['nombre' => $usuarioNombre]);

if (!$usuario || empty($usuario['cesta'])) {
    echo "<script>alert('Tu carrito está vacío. Agrega productos antes de comprar.'); window.location.href='carrito.php';</script>";
    exit();
}

$nuevoPedido = [
    'usuario' => $usuarioNombre,
    'productos' => $usuario['cesta'],
];

$pedidosCollection->insertOne($nuevoPedido);

$usuariosCollection->updateOne(
    ['nombre' => $usuarioNombre],
    ['$set' => ['cesta' => []]]
);

echo "<script>window.location.href='carrito.php';</script>";
?>
