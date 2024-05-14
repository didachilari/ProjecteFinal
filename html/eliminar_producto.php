<?php
// Inicia la sesión para acceder a los datos del carrito
session_start();

// Verifica si se recibió el ID del producto a eliminar
if(isset($_POST['id_producte'])) {
    // Obtiene el ID del producto desde el formulario
    $idProductoEliminar = $_POST['id_producte'];

    // Busca el índice del producto en el carrito
    $indice = array_search($idProductoEliminar, $_SESSION['carrito']);

    // Si el producto está en el carrito, lo elimina
    if($indice !== false) {
        unset($_SESSION['carrito'][$indice]);
        // Reindexa el array de carrito
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}
// Redirige de nuevo a la página del carrito
header("Location: carrito.php");
exit();
?>
