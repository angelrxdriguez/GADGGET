<?php
$error = isset($_GET['error']) ? $_GET['error'] : '';
$mensaje = '';
if ($error === 'vacio') {
    $mensaje = 'Por favor, completa todos los campos.';
} elseif ($error === 'contraseña') {
    $mensaje = 'LAS CONTRASEÑAS NO COINCIDEN';
} elseif ($error === 'usuario') {
    $mensaje = 'EL NOMBRE YA ESTÁ EN USO';
} elseif ($error === 'exito') {
    $mensaje = 'USUARIO REGISTRADO CORRECTAMENTE';
} elseif ($error === 'fallo') {
    $mensaje = 'NO SE HA PODIDO REGISTRAR';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDEX</title>
    <link rel="icon" type="image/png" href="fotos/enelpueblo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ballet:opsz@16..72&family=Lacquer&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilolog.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html">
            <img src="logos/gadget.jpg" alt="Logo" height="90" class="logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">HOME</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="tienda.php">TIENDA</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="gadgget.php">GADGGET</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pedidos.php">PEDIDOS</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="carrito.php">
                        <img src="ico/carrito-de-compras (1).png" alt="Carrito" height="35" class="nav-icon">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">
                        <img src="ico/acceso (3).png" alt="Sesion" height="35" class="nav-icon">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<section class="vh-100">
    <div class="container py-5 h-1200">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" >
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="logos/gadget.jpg" 
                  alt="login form" class="img-fluid" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">
                <?php if ($mensaje): ?>
<div class="alert alert-danger" role="alert">
  <?php echo htmlspecialchars($mensaje); ?>
</div>
<?php endif; ?>
                    <form method="post" action="checkcontra.php">
                        <div class="d-flex align-items-center mb-3 pb-1">
                            <span class="h1">GADG</span>
                        </div>
                    
                        <h5 class="fw-normal mb-3 pb-3">CREA UNA CUENTA NUEVA</h5>
                    
                        <div class="form-outline mb-4">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control form-control-lg" required />
                        </div>
                    
                        <div class="form-outline mb-4">
                            <label class="form-label" for="contra1">Contraseña</label>
                            <input type="password" id="contra1" name="contra1" class="form-control form-control-lg" required />
                        </div>
                    
                        <div class="form-outline mb-4">
                            <label class="form-label" for="contra2">Repite Contraseña</label>
                            <input type="password" id="contra2" name="contra2" class="form-control form-control-lg" required />
                        </div>
                    
                        <div class="pt-1 mb-4">
                            <button class="btn btn-dark btn-lg btn-block" type="submit">CREAR CUENTA</button>
                        </div>
                    
                        <p class="mb-5 pb-lg-2">¿Ya tienes cuenta? <a class="registro" href="login.php">¡Inicia Sesión Aquí!</a></p>
                    </form>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>