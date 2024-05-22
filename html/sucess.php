<?php
session_start();
include "./../functions/db_connection.php";

// Verificar si la sesión del carrito no está vacía
if (!empty($_SESSION['carrito'])) {
    // Obtener los IDs de los productos del carrito
    $productosID = implode(',', $_SESSION['carrito']);
    
    // Eliminar los productos comprados de la base de datos
    $sql = "DELETE FROM producte WHERE id_producte IN ($productosID)";
    if ($conn->query($sql) === TRUE) {
        echo "Productos comprados eliminados correctamente.";
    } else {
        echo "Error al eliminar los productos: " . $conn->error;
    }
    
    // Limpiar el carrito de la sesión
    $_SESSION['carrito'] = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Exitosa</title>
</head>
<body>
    <h1>Gracias por tu compra</h1>
    <p>Tu compra se ha realizado con éxito y los productos han sido eliminados de la base de datos.</p>
    <a href="./../index.php">Volver a la tienda</a>
</body>
</html>
