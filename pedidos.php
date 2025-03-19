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

// Verificar si el usuario está en sesión
if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Debes iniciar sesión para esto'); window.location.href='login.html';</script>";
    exit();
}

// Buscar el usuario en la base de datos
$usuario = $usuariosCollection->findOne(['_id' => new ObjectId($_SESSION['usuario'])]);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="icon" type="image/png" href="fotos/enelpueblo.png">
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html">
            <img src="logos/gadget.jpg" alt="Logo" height="90" class="logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tienda.php">TIENDA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="conciertos.html">GADGGET</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="pedidos.php">PEDIDOS</a>
                </li>
                <li class="nav-item">
                    <?php if ($usuario): ?>
                        <a class="nav-link" href="usuario.php">
                            <?= htmlspecialchars($usuario['nombre'] ?? 'Usuario'); ?>
                        </a>
                    <?php else: ?>
                        <a class="nav-link" href="login.html">
                            <img src="ico/acceso (2).png" alt="Sesion" height="35" class="nav-icon">
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
