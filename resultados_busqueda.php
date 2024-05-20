<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="./style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<title>Index</title>
</head>
<body class="index">
<header>
  <div class="container">
    <div class="cabecera">
      <div class="row">
        <div class="col">
          <a class="navbar-brand" href="./index.php">CoutureApp</a>
        </div>
        <div class="col">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./html/pagina-usuario.php"><i class="bi bi-person-circle"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-cart" href="./html/carrito.php"><i class="bi bi-cart"></i><span id="contadorCarrito" class="contador-carrito">0</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./index.php"><i class="bi bi-house-door"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="flex-mobile">
    
  </div>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="buscador">
        <form class="d-flex" role="search" action="resultados_busqueda.php" method="GET" onsubmit="return validar()">
          <button class="btn" type="submit"><i class="bi bi-search"></i></button>
          <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search" name="search" id="searchInput">
        </form>
      </div>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./html/camisa.php">Camisa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./html/camiseta.php">Camiseta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./html/pantalon.php">Pantalon</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./html/chaquetas.php">Chaquetas</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./html/calzado.php">Calzado</i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "couture";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Variable para guardar la búsqueda y si está vacía se asigna un string vacío
$searchTerm = $_GET['search'] ?? '';

if (!empty($searchTerm)) {
    // Consulta SQL del buscador que busca por la consulta que realizamos
    $sql = "SELECT p.*, u.nom_usuari 
            FROM producte p 
            INNER JOIN usuario u ON p.id_usuari = u.id_usuari
            WHERE p.nom LIKE '%$searchTerm%'"; // Filtro por el nombre que contenga el artículo que hemos puesto en el buscador
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar resultados
        while ($row = $result->fetch_assoc()) {
            echo "<div class='contenedor-articulo'>";
            echo "<div class='usuario'>";
            echo "<img src='./img/user-line.svg' alt=''>";
            echo "<span class='n-usuario'>" . $row["nom_usuari"] . "</span>";
            echo "</div>";
            echo "<button type='button' class='boton-corazon'>";
            echo "<img src='./img/heart.svg' alt=''>";
            echo "</button>";
            echo "<div class='imagen' style='text-align:center;'>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['foto']) . "' alt=''>";
            echo "</div>";
            echo "<div class='contenido'>";
            echo "<div class='row con-icon'>";
            echo "<div class='col-6'>";
            echo "<div class='c-1'>";
            echo "<span>" . $row["nom"] . "</span>";
            echo "<br>";
            echo "<span> Precio: " . $row["preu"] . "€</span>";
            echo "<br>";
            echo "</div>";
            echo "</div>";
            echo "<div class='col-6'>";
            echo "<div class='c-2'>";
            echo "<div class='row h-b'>";
            echo "<button type='button' class='boton-carro' onclick='agregarAlCarrito(" . $row['id_producte'] . ")'>";
            echo "<img src='./img/bag.svg' alt=''>";
            echo "</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        // No se encontraron resultados, redireccionar a index.php
        header("Location: index.php");
        exit();
    }
} else {
    // Si no se proporcionó ningún término de búsqueda, redireccionar a index.php
    header("Location: index.php");
    exit();
}

$conn->close();
?>
</body>
</html>
