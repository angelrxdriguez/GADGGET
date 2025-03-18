<?php
require 'vendor/autoload.php';
require 'veradmin.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget; 
$collection = $database->pedidos;

$pedidos = $collection->find();

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
                    <li class="nav-item"><a class="nav-link active" href="admproductos.php">PRODUCTOS</a></li>
                    <li class="nav-item"><a class="nav-link" href="admstock.php">STOCK</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 gestion text-center">
        <h2 class="text-white">Gestión de Pedidos</h2>
    </div>

    <div class="modal fade" id="cancelarPedido" tabindex="-1" aria-labelledby="cancelarPedido" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Estás seguro de que deseas cancelar el Pedido?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>El usuario no recibirá el pedido.</p>
                <form id="borrarForm" action="cancelarpedido.php" method="POST">
                    <input type="hidden" name="id" id="pedidoId">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Cancelar Pedido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="contenedorpedidos">
    <?php foreach ($pedidos as $pedido): ?>
        <div class="pedido">
            <h3 class="nombreped">De99: <?= htmlspecialchars($pedido['usuario']) ?></h3>

            <?php if (isset($pedido['productos']) && is_array($pedido['productos'])): ?>
                <?php foreach ($pedido['productos'] as $producto): ?>
                    <div class="producto">
                        <?php
                        // Obtener detalles del producto
                        $producto_id = isset($producto['producto_id']) ? $producto['producto_id'] : null;
                        $cantidad = isset($producto['cantidad']) ? $producto['cantidad'] : 'Cantidad desconocida';

                        // Comprobar si el producto_id es válido
                        if ($producto_id) {
                            // Realizar la consulta para obtener el producto utilizando el ObjectId
                            try {
                                $producto_id_obj = new MongoDB\BSON\ObjectId($producto_id);
                                $producto_data = $database->productos->findOne([
                                    '_id' => $producto_id_obj
                                ]);
                            } catch (Exception $e) {
                                echo "Error al obtener el producto: " . $e->getMessage();
                                $producto_data = null;
                            }

                            // Verificar si se encontraron datos del producto
                            if ($producto_data) {
                                $nombre_producto = isset($producto_data['nombre']) ? $producto_data['nombre'] : 'Producto no encontrado';
                                $imagen_producto = isset($producto_data['imagen']) ? $producto_data['imagen'] : 'img/default.jpg';
                            } else {
                                $nombre_producto = 'Producto no encontrado';
                                $imagen_producto = 'img/default.jpg';
                            }
                        } else {
                            $nombre_producto = 'ID de producto no válido';
                            $imagen_producto = 'img/default.jpg';
                        }

                        // Depuración: Verificar que el producto_id y la consulta están funcionando
                        var_dump($producto_id); // Esto te ayudará a ver los valores de producto_id en el pedido
                        var_dump($producto_data); // Esto te permitirá ver la respuesta de la consulta

                        ?>

                        <!-- Mostrar información del producto -->
                        <img src="<?= htmlspecialchars($imagen_producto) ?>" class="fotoped" alt="<?= htmlspecialchars($nombre_producto) ?>">
                        <h3 class="titped"><?= htmlspecialchars($nombre_producto) ?></h3>
                        <h3 class="cantidadped">Cantidad: <?= htmlspecialchars($cantidad) ?></h3>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <button class="btn btn-danger mt-3 cancelar" data-bs-toggle="modal" data-bs-target="#cancelarPedido" 
                data-id="<?= $pedido['_id'] ?>">
                CANCELAR PEDIDO
            </button>
        </div>
    <?php endforeach; ?>
</div>



    <footer class="text-center text-white">
        <div class="container">
            <section class="mt-5">
                <div class="row text-center d-flex justify-content-center pt-5">
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="home" class="text-white">Home</a>
                        </h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="discos.html" class="text-white">Discos</a>
                        </h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="conciertos.html" class="text-white">Conciertos</a>
                        </h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="contacto.html" class="text-white">Contacto</a>
                        </h6>
                    </div>
                    <div class="col-md-2">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="login.html" class="text-white">SESIÓN</a>
                        </h6>
                    </div>
                </div>
            </section>
            <hr class="my-5" />
            <section class="mb-5">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <p>
                            Página web Prototipo de tienda funcional elaborada por Ángel Panadero Rodríguez. Estudiante
                            2º año Desarrollo de Aplicaciones Web.
                        </p>
                    </div>
                </div>
            </section>
            <section class="text-center mb-5">
                <a href="https://x.com/i/flow/login?redirect_after_login=%2Fjarfaiter_dice" class="text-white me-4">
                    <img src="iconos/twitter (1).png" alt="" class="iconofooter">
                </a>
                <a href="https://www.facebook.com/login/?next=https%3A%2F%2Fwww.facebook.com%2Fjarfaiter%2F%3Flocale%3Des_ES"
                    class="text-white me-4">
                    <img src="iconos/facebook (1).png" alt="" class="iconofooter">
                </a>
                <a href="https://www.youtube.com/channel/UCUCxEgrssyvszRfaLBmFxhA" class="text-white me-4">
                    <img src="iconos/youtube (1).png" alt="" class="iconofooter">
                </a>
            </section>
        </div>
        <div class="text-center p-3">
            © 2025 Copyright:
            <a class="text-white" href="contacto.html">GADGGET</a>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="src/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
