<?php
include './functions/db_connection.php';

$categoria = $_POST['categoria'];

$sql = "SELECT p.nom, p.preu, p.foto, p.categorias, p.me_gusta, u.nom_usuari 
        FROM producte p 
        INNER JOIN usuario u ON p.id_usuari = u.id_usuari";

if (!empty($categoria)) {
    $sql .= " WHERE p.categorias = '$categoria'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="contenedor-articulo">';
        echo '<div class="usuario">';
        echo '<img src="./img/user-line.svg" alt="">';
        echo '<span class="n-usuario">' . $row["nom_usuari"] . '</span>'; // Nombre de usuario obtenido de la tabla usuario
        echo '</div>';
        echo '<div class="imagen" style="text-align:center";>';
        // Establecer el tamaño máximo de la imagen usando CSS
        echo '<img src="data:image/jpeg;base64,'.base64_encode($row['foto']).'" alt="" style="max-width: 500px; max-height: 500px; object-fit: contain;">';
        echo '</div>';
        echo '<div class="contenido">';
        echo '<div class="row con-icon">';
        echo '<div class="col-6">';
        echo '<div class="c-1">';
        echo '<span> Nombre: ' . $row["nom"] . '</span>'; // Aquí se imprime el nombre del producto
        echo '<br>';
        echo '<span> Precio: ' . $row["preu"] . '€</span>'; // Luego se imprime el precio
        echo '<br>';
        echo '<span>' . $row["me_gusta"] . '</span>';
        echo '<br>';
        echo '</div>';
        echo '</div>';
        echo '<div class="col-6">';
        echo '<div class="c-2">';
        echo '<div class="row h-b">';
        echo '<button type="button" class="boton-corazon">
              <img src="./img/heart.svg" alt="">
              </button>';
        echo '<button type="button" class="boton-corazon">
        <img src="./img/bag.svg" alt="">
              </button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No se encontraron productos";
}

$conn->close();
?>
