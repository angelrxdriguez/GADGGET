<?php
session_start();
require 'vendor/autoload.php'; 

$uri = "mongodb+srv://angelrp:abc123.@cluster0.76po7.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
$client = new MongoDB\Client($uri);
$database = $client->gadgget; 
$collection = $database->usuarios; 

$nombre = $_POST['nombre'];
$contra = $_POST['contra'];

if ($nombre === "admin" && $contra === "abc123.") {
    $_SESSION['usuario'] = "admin";
    header('Location: admin.php');
    exit();
}

$user = $collection->findOne(['nombre' => $nombre]);

if ($user) {
    if ($contra === $user['contra']) {
        $_SESSION['usuario'] = $nombre; 
        header('Location: index.php');
        exit();
    } else {
        header('Location: login.php?error=contra');
        exit();
    }
} else {
    header('Location: login.php?error=usuario');
    exit();
}

?>
