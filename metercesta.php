<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new Client($uri);
$database = $client->gadgget;
$usuariosCollection = $database->usuarios;

// Verificar que el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('INICIA SESION ANTES DE HACER ESTO'); window.location.href='login.html';</script>";
    exit();
}

// Verificar que se recibió el ID del producto
if (!isset($_POST['id'])) {
    echo "<script>alert('Error: No se ha seleccionado ningún producto.'); window.location.href='tienda.php';</script>";
    exit();
}

$productoId = new ObjectId($_POST['id']);
$usuarioNombre = $_SESSION['usuario'];

// Buscar al usuario en la base de datos
$usuario = $usuariosCollection->findOne(['nombre' => $usuarioNombre]);

if (!$usuario) {
    echo "<script>alert('Error: Usuario no encontrado.'); window.location.href='tienda.php';</script>";
    exit();
}

// Agregar el producto al array "cesta" en MongoDB
$usuariosCollection->updateOne(
    ['nombre' => $usuarioNombre],
    ['$addToSet' => ['cesta' => $productoId]] // Evita duplicados
);

echo "<script>alert('Producto añadido al carrito.'); window.location.href='tienda.php';</script>";
?>
