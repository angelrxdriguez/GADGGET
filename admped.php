<?php
require 'vendor/autoload.php';
require 'veradmin.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget;
$collection_pedidos = $database->pedidos;
$collection_productos = $database->productos; 

$pedidos = $collection_pedidos->find();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="icon" type="image/png" href="fotos/enelpueblo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ballet:opsz@16..72&family=Lacquer&family=Oswald:wght@200..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="logos/gadget.jpg" alt="Logo" height="90" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="admin.php">ADMINISTRADOR</a></li>
                    <li class="nav-item"><a class="nav-link" href="admproductos.php">PRODUCTOS</a></li>
                    <li class="nav-item"><a class="nav-link" href="admstock.php">STOCK</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admped.php">PEDIDOS</a></li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container mt-5 gestion text-center">
    <h2 class="text-white">Gestión de Pedidos</h2>
</div>

<div class="contenedorpedidos">
    <?php foreach ($pedidos as $pedido): ?>
        <div class="pedido">
            <h4 class="text-muted">ID: <?= $pedido['_id'] ?></h4>

            <?php foreach ($pedido['productos'] as $producto): 
                $productoDatos = $collection_productos->findOne(['_id' => new MongoDB\BSON\ObjectId($producto['producto_id'])]);
            ?>
                <div class="datos">
                    <img src="<?= $productoDatos['imagen'] ?>" class="fotoped" alt="">
                    <h3 class="titped"><?= $productoDatos['nombre'] ?></h3>
                    <h3 class="cantidadped">Pide : <?= $producto['cantidad'] ?></h3>
                    <h3 class="stockped">Stock : <?= $productoDatos['stock'] ?></h3>
                </div>
            <?php endforeach; ?>

            <div class="botones">
                <button class="btn btn-danger cancelar" data-bs-toggle="modal" data-bs-target="#cancelarModal-<?= $pedido['_id'] ?>">
                    CANCELAR PEDIDO
                </button>
                <button class="btn btn-success aceptar" data-bs-toggle="modal" data-bs-target="#aceptarModal-<?= $pedido['_id'] ?>">
                    ACEPTAR PEDIDO
                </button>
            </div>
        </div>

        <div class="modal fade" id="cancelarModal-<?= $pedido['_id'] ?>" tabindex="-1" aria-labelledby="cancelarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelarModalLabel">¿Cancelar pedido?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Este pedido no se tramitará</p>
                        <form action="cancelarpedido.php" method="POST">
                            <input type="hidden" name="pedido_id" value="<?= $pedido['_id'] ?>">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-danger">Cancelar pedido</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="aceptarModal-<?= $pedido['_id'] ?>" tabindex="-1" aria-labelledby="aceptarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aceptarModalLabel">¿Aceptar pedido?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Este pedido se tramitará</p>
                        <form action="aceptarpedido.php" method="POST">
                            <input type="hidden" name="pedido_id" value="<?= $pedido['_id'] ?>">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Aceptar pedido</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="src/jquery.js"></script>
</body>
</html>
