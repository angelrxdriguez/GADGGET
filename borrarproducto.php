<?php
require 'vendor/autoload.php';
require 'veradmin.php'; 

// Conectar a MongoDB
$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget; 
$collection = $database->productos;

// Verificar que el ID del producto se haya enviado por POST
if (isset($_POST['id'])) {
    $productoId = $_POST['id'];

    // Borrar el producto de la base de datos
    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($productoId)]);

    // Si el producto se eliminó con éxito, redirigir a la página de productos
    if ($result->getDeletedCount() > 0) {
        header('Location: admproductos.php'); // Redirigir al listado de productos
        exit;
    } else {
        echo 'Error al eliminar el producto';
    }
}
?>
