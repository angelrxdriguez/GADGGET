<?php
require 'vendor/autoload.php';

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget;
$collection_pedidos = $database->pedidos;
$collection_pedidosAceptados = $database->pedidosAceptados;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pedido_id"])) {
    $pedido_id = $_POST["pedido_id"];
    
    try {
        $pedido = $collection_pedidos->findOne(['_id' => new MongoDB\BSON\ObjectId($pedido_id)]);

        if ($pedido) {
            $collection_pedidosAceptados->insertOne($pedido);

            $collection_pedidos->deleteOne(['_id' => new MongoDB\BSON\ObjectId($pedido_id)]);
        }

        header("Location: admped.php");
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Solicitud no válida.";
}
?>
