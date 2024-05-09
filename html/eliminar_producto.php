<?php
//iniciarem la sessió
session_start();

//verificarem s'hi s'ha rebut l'ID del producte a eliminar
if(isset($_POST['id_producte'])) {
    //obtindrem l'ID del producte desde el formulari
    $idProductoEliminar = $_POST['id_producte'];

    //buscarem la posició del producte en l'array del carrito
    $indice = array_search($idProductoEliminar, $_SESSION['carrito']);

    //si el producte esta en el carrito, l'elimina
    if($indice !== false) {
        unset($_SESSION['carrito'][$indice]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}
//redirigeix al carrito
header("Location: carrito.php");
exit();
?>
