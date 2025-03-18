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
    echo "<script>alert('INICIA SESIÓN PARA COMPRAR.'); window.location.href='login.html';</script>";
    exit();
}

$usuarioNombre = $_SESSION['usuario'];

// Obtener usuario y su cesta
$usuario = $usuariosCollection->findOne(['nombre' => $usuarioNombre]);

if (!$usuario || empty($usuario['cesta'])) {
    echo "<script>alert('Tu carrito está vacío. Agrega productos antes de comprar.'); window.location.href='carrito.php';</script>";
    exit();
}

// Crear un pedido con los productos de la cesta
$nuevoPedido = [
    'usuario' => $usuarioNombre,
    'productos' => $usuario['cesta'],
];

// Insertar el pedido en la colección pedidos
$pedidosCollection->insertOne($nuevoPedido);

// Vaciar la cesta del usuario
$usuariosCollection->updateOne(
    ['nombre' => $usuarioNombre],
    ['$set' => ['cesta' => []]]
);

echo "<script>alert('Compra realizada con éxito.'); window.location.href='carrito.php';</script>";
?>
