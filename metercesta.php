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
    echo "<script>alert('INICIA SESIÓN ANTES DE HACER ESTO'); window.location.href='login.html';</script>";
    exit();
}

if (!isset($_POST['id'])) {
    echo "<script>alert('Error: No se ha seleccionado ningún producto.'); window.location.href='tienda.php';</script>";
    exit();
}

$productoId = new ObjectId($_POST['id']);
$usuarioNombre = $_SESSION['usuario'];

$producto = $productosCollection->findOne(['_id' => $productoId]);

if (!$producto) {
    echo "<script>alert('Error: Producto no encontrado.'); window.location.href='tienda.php';</script>";
    exit();
}
//si hay stock
if ($producto['stock'] <= 0) {
    echo "<script>alert('Lo sentimos, este producto está agotado.'); window.location.href='tienda.php';</script>";
    exit();
}

$usuario = $usuariosCollection->findOne(['nombre' => $usuarioNombre]);

if (!$usuario) {
    echo "<script>alert('Error: Usuario no encontrado.'); window.location.href='tienda.php';</script>";
    exit();
}

$productoEnCesta = false;
foreach ($usuario['cesta'] as &$item) {
    if ($item['producto_id'] == (string) $productoId) {
        $item['cantidad'] += 1;
        $productoEnCesta = true;
        break;
    }
}

if (!$productoEnCesta) {
    $usuario['cesta'][] = [
        'producto_id' => (string) $productoId,
        'cantidad' => 1
    ];
}

$usuariosCollection->updateOne(
    ['nombre' => $usuarioNombre],
    ['$set' => ['cesta' => $usuario['cesta']]]
);

$productosCollection->updateOne(
    ['_id' => $productoId],
    ['$inc' => ['stock' => -1]]
);

echo "<script>window.location.href='tienda.php';</script>";
?>
