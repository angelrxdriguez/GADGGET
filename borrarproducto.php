<?php
require 'vendor/autoload.php';
require 'veradmin.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget; 
$collection = $database->productos;

if (isset($_POST['id'])) {
    $productoId = $_POST['id'];

    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($productoId)]);

   
    if ($result->getDeletedCount() > 0) {
        header('Location: admproductos.php'); //ok prod
        exit;
    } else {
        echo 'Error al eliminar el producto';
    }
}
?>
