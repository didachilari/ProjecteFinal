<?php
include "./../functions/db_connection.php";

// Obtener el ID del producto desde la URL
$productId = $_GET['id'];

// Consulta SQL para obtener los detalles del producto
$sql = "SELECT p.*, u.nom_usuari 
        FROM producte p
        INNER JOIN usuario u ON p.id_usuari = u.id_usuari
        WHERE p.id_producte = $productId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Producto no encontrado";
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Detalle del Producto</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 2em;
        }
        .product-image {
            text-align: center;
            margin-bottom: 20px;
        }
        .product-image img {
            max-width: 100%;
            height: auto;
        }
        .product-details {
            margin-bottom: 20px;
        }
        .product-details h2 {
            margin: 0 0 10px 0;
            font-size: 1.5em;
            color: #333;
        }
        .product-details p {
            margin: 5px 0;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detalles del Producto</h1>
        </div>
        <div class="product-image">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['foto']); ?>" alt="Imagen del Producto">
        </div>
        <div class="product-details">
    <h2><?php echo $row['nom']; ?></h2>
    <p><strong>Descripción:</strong> <?php echo $row['descripcio']; ?></p> <!-- Agregar esta línea para mostrar la descripción -->
    <p><strong>Precio:</strong> <?php echo $row['preu']; ?>€</p>
    <p><strong>Categoría:</strong> <?php echo $row['categorias']; ?></p>
    <p><strong>Marca:</strong> <?php echo $row['id_marcas']; ?></p>
    <p><strong>Subido por:</strong> <?php echo $row['nom_usuari']; ?></p>
</div>
    </div>
</body>
</html>
