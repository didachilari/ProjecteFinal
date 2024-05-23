<?php
//iniciem la sessió
session_start();

//verificarem si la sessió del carrito existeix, si no la sessió la iniciarem
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

//amb el $_POST obtinedrem el id del producte enviat al carrito
$idProducto = $_POST['id'];

//afegirem el producto al carrito
$_SESSION['carrito'][] = $idProducto;
?>
