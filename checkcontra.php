<?php
require 'vendor/autoload.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget; 
$collection = $database->usuarios; 

$nombre = trim($_POST['nombre']);
$contra1 = $_POST['contra1'];
$contra2 = $_POST['contra2'];

// No meter vacíos
if (empty($nombre) || empty($contra1) || empty($contra2)) {
    header("Location: registro.php?error=vacio");
    exit();
}

// Contraseñas no coinciden
if ($contra1 !== $contra2) {
    header("Location: registro.php?error=contraseña");
    exit();
}

// Nombre ya en uso
$user = $collection->findOne(['nombre' => $nombre]);

if ($user) {
    header("Location: registro.php?error=usuario");
    exit();
}

// Mete en la base
$result = $collection->insertOne([
    'nombre' => $nombre,
    'contra' => $contra1,
    'cesta' => []
]);

if ($result->getInsertedCount() > 0) {
    header("Location: login.php");
    exit();
} else {
    header("Location: registro.php?error=fallo");
    exit();
}
?>
