<?php
//iniciarem la sessió
session_start();

// verificarem si la sessió del carrito existeix si no l'iniicialitzarem
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

//obtindrem la id del producte
$idProducto = $_POST['id'];

//afegirem la id del producte a la sessió del carrito
$_SESSION['carrito'][] = $idProducto;
?>
