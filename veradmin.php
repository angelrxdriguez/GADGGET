<?php
session_start();

// Si no hay sesión iniciada o no es admin, redirige a login.php
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== "admin") {
    header("Location: login.html");
    exit();
}

// Si llega aquí, significa que es admin y puede continuar
?>
