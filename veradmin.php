<?php
session_start();

// Si no hay sesión iniciada, redirige a login.php
if (!isset($_SESSION['usuario']) || !isset($_SESSION['contra'])) {
    header("Location: login.php");
    exit();
}

// Verificar si el usuario es admin con la contraseña correcta
if ($_SESSION['usuario'] !== "admin" || $_SESSION['contra'] !== "abc") {
    header("Location: login.php");
    exit();
}

// Si llega aquí, significa que es admin y puede continuar
?>
