<?php
require 'vendor/autoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productoId = $_POST['productoId'];
    $cantidad = intval($_POST['cantidad']); 

    if (empty($productoId) || $cantidad <= 0) {
        die("Error: Datos inválidos.");
    }

    try {
        $uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
        $client = new MongoDB\Client($uri);
        $database = $client->gadgget;
        $collection = $database->productos;

        $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($productoId)],
            ['$inc' => ['stock' => -$cantidad]]
        );

        header("Location: admstock.php");
        exit();
    } catch (Exception $e) {
        echo "Error al actualizar el stock: " . $e->getMessage();
    }
} else {
    echo "Método de acceso no permitido.";
}
?>
