<?php
// Iniciar sesión
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$database = "couture";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Realizar consulta SQL para obtener productos de la categoría "Camisa"
$sql = "SELECT * FROM producte WHERE categorias LIKE '%Calzado%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generar el HTML para mostrar los productos
    $output = '<div class="productos-container">';
    while ($row = $result->fetch_assoc()) {
        $output .= '<div class="producto">';
        $output .= '<h3>' . $row['nom'] . '</h3>';
        $output .= '<p>Categoría: ' . $row['categorias'] . '</p>';
        $output .= '<p>Precio: ' . $row['preu'] . '€</p>';
        $output .= '<img src="data:image/jpeg;base64,' . base64_encode($row['foto']) . '" alt="' . $row['nom'] . '">';
        $output .= '</div>';
    }
    $output .= '</div>';

    echo $output;
} else {
    echo "No se encontraron productos en la categoría 'Calzado'.";
}

// Cerrar la conexión
$conn->close();
?>
