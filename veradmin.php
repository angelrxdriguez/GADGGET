<?php
session_start();
//si no es nombre admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== "admin") {
    header("Location: login.html");
    exit();
}

?>
