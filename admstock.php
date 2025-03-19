<?php
require 'vendor/autoload.php';
require 'veradmin.php'; // Verifica la sesión del admin

// Conectar a MongoDB
$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget; 
$collection = $database->productos; 

// Obtener todos los productos
$productos = $collection->find();
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
                    <li class="nav-item"><a class="nav-link active" href="admstock.php">STOCK</a></li>
                    <li class="nav-item"><a class="nav-link" href="admped.php">PEDIDOS</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 gestion text-center">
        <h2 class="text-white">Gestión de Stock</h2>
    </div>
<!--la s antes para en el css diferenciarlo de otras etiquetas-->
<div class="productosstock">
    <div class="row">
        <?php foreach ($productos as $producto): ?>
            <div class="productostock">
                <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                <div class="producto-info">
                    <p class="text-muted sid">ID: <?= htmlspecialchars($producto['_id']) ?></p>
                    <h5 class="snombre"><?= htmlspecialchars($producto['nombre']) ?></h5>
                    <h5 class="sstock">STOCK: <?= htmlspecialchars($producto['stock']) ?></h5>
                </div>
                <div class="botonesstock">
                    <button class="btn btn-success sumarstock-btn" data-bs-toggle="modal" data-bs-target="#sumarStockModal" data-id="<?= $producto['_id'] ?>">+ STOCK</button>
                    <button class="btn btn-danger restarstock-btn" data-bs-toggle="modal" data-bs-target="#restarStockModal" data-id="<?= $producto['_id'] ?>">- STOCK</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<div class="modal fade" id="sumarStockModal" tabindex="-1" aria-labelledby="sumarStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sumarStockModalLabel">Sumar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="sumarstock.php" method="POST">
                    <input type="hidden" id="productoIdSumar" name="productoId">
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad a Sumar</label>
                        <input type="number" class="form-control" id="cantidadSumar" name="cantidad" required min="1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Sumar Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="restarStockModal" tabindex="-1" aria-labelledby="restarStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restarStockModalLabel">Restar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="restarstock.php" method="POST">
                    <input type="hidden" id="productoIdRestar" name="productoId">
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad a Restar</label>
                        <input type="number" class="form-control" id="cantidadRestar" name="cantidad" required min="1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Restar Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
