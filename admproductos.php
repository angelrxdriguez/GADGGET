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
                    <li class="nav-item"><a class="nav-link active" href="admproductos.php">PRODUCTOS</a></li>
                    <li class="nav-item"><a class="nav-link" href="admstock.php">STOCK</a></li>
                    <li class="nav-item"><a class="nav-link" href="admped.php">PEDIDOS</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 gestion text-center">
        <h2 class="text-white">Gestión de Productos</h2>
        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#productoModal">Añadir Producto</button>
    </div>

    <div class="modal fade" id="productoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                <form action="crearproducto.php" method="POST">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
    </div>
    <div class="mb-3">
        <label for="imagen" class="form-label">Ruta de la Imagen</label>
        <input type="text" class="form-control" id="imagen" name="imagen" required>
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Stock Inicial</label>
        <input type="number" class="form-control" id="stock" name="stock" required>
    </div>
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo de Producto</label>
        <select class="form-control" id="tipo" name="tipo" required>
            <option value="raton">Raton</option>
            <option value="teclado">Teclado</option>
            <option value="cascos">Cascos</option>
            <option value="home">Home</option>
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar Producto</button>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="borrarModal" tabindex="-1" aria-labelledby="borrarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="borrarModalLabel">¿Estás seguro de que deseas borrar este producto?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Este producto será eliminado permanentemente.</p>
                <form id="borrarForm" action="borrarproducto.php" method="POST">
                    <input type="hidden" name="id" id="productoId">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Borrar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <div class="productos adm">
            <?php foreach ($productos as $producto): ?>
                    <div class="card producto">
                        <img class="card-img-top" src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($producto['descripcion']) ?></p>
                            <h6 class="precio">$<?= number_format(floatval($producto['precio']), 2) ?></h6>
                            <h6 class="stock">STOCK - <?= intval($producto['stock']) ?></h6>
                            <h5 class="card-title"><?= htmlspecialchars($producto['tipo']) ?></h5>
                            <button class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#borrarModal" data-id="<?= $producto['_id'] ?>">
                                BORRAR PRODUCTO
                            </button>
                        </div>
                    </div>
            <?php endforeach; ?>
    </div>

    <footer class="text-center text-white" style="background-color: #000000">
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
              <a href="tienda.php" class="text-white">Tienda</a>
            </h6>
          </div>
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="gadgget.php" class="text-white">Gadgget</a>
            </h6>
          </div>
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="pedidos.php" class="text-white">Pedidos</a>
            </h6>
          </div>
        </div>
      </section>
      <hr class="my-5" />
      <section class="mb-5">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8">
            <p>
              Página web Prototipo de tienda funcional elaborada por Ángel Panadero Rodríguez. Estudiante 2º año Desarrollo de Aplicaciones Web.
            </p>
          </div>
        </div>
      </section>
      <section class="text-center mb-5">
        <a href="https://x.com/i/flow/login?redirect_after_login=%2Fjarfaiter_dice" class="text-white ">
          <img src="ico/twitter.png" alt="" class="iconofooter">
        </a>
        <a href="https://www.facebook.com/login/?next=https%3A%2F%2Fwww.facebook.com%2Fjarfaiter%2F%3Flocale%3Des_ES" class="text-white ">
            <img src="ico/facebook.png" alt="" class="iconofooter">
        </a>
        <a href="https://www.youtube.com/channel/UCUCxEgrssyvszRfaLBmFxhA" class="text-white ">
            <img src="ico/youtube (1).png" alt="" class="iconofooter">
        </a>
      </section>
    </div>
    <div
         class="text-center p-3"
         >
      © 2025 Copyright:
      <a class="text-white" href=""
         >GADGGET</a   
        >
    </div>
  </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="src/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
