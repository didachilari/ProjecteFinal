<?php
// Inicia la sesión para mantener los datos del carrito
session_start();

// Verifica si la sesión del carrito existe, si no, inicialízala
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Obtén el ID del producto enviado desde index.php
$idProducto = $_POST['id'];

// Agrega el ID del producto a la sesión del carrito
$_SESSION['carrito'][] = $idProducto;
?>
