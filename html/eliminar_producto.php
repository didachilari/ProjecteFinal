<?php
//iniciarem la sessió
session_start();

//aqui verificarem s'hi s'ha rebut la ID del producte que volem eliminar
if(isset($_POST['id_producte'])) {
    //obtindrem la ID del producte desde el formulari
    $idProductoEliminar = $_POST['id_producte'];

    //buscarem el id del producte en el carrito
    $id = array_search($idProductoEliminar, $_SESSION['carrito']);

    //s'hi el producte está en el carrito l'eliminara 
    if($id !== false) {
        unset($_SESSION['carrito'][$id]);
        //actualitza l'array del carrito
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}
//redireix a la pàgina del carrito
header("Location: carrito.php");
exit();
?>
