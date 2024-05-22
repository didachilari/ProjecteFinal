<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../style.css">
    <title>Productos del Usuario</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>
<body>
<header>
  <div class="container">
    <div class="cabecera">
      <div class="row">
        <div class="col">
          <a class="navbar-brand" href="./../index.php">Couture<span>App</span></a>
        </div>
        <div class="col">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./pagina-usuario.php"><i class="bi bi-person-circle"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-cart" href="./carrito.php"><i class="bi bi-cart"></i><span id="contadorCarrito" class="contador-carrito">0</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./../index.php"><i class="bi bi-house-door"></i></a>
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
<div class="container">
  
  <h2>Busquedas de usuario</h2>
  <?php
    include "./../functions/db_connection.php";

    // Obtener el término de búsqueda del nombre de usuario desde la URL
    $searchTerm = $_GET['search'];

    // Consulta SQL para obtener el ID del usuario basado en el nombre de usuario buscado
    $sql_user_id = "SELECT id_usuari FROM usuario WHERE nom_usuari LIKE '%$searchTerm%'";
    $result_user_id = $conn->query($sql_user_id);

    if ($result_user_id->num_rows > 0) {
        $row_user_id = $result_user_id->fetch_assoc();
        $userId = $row_user_id['id_usuari'];

        // Consulta SQL para obtener los productos del usuario según el ID de usuario
        $sql_products = "SELECT p.*, u.nom_usuari 
                         FROM producte p 
                         INNER JOIN usuario u ON p.id_usuari = u.id_usuari
                         WHERE p.id_usuari = $userId";
        
        $result_products = $conn->query($sql_products);

        if ($result_products->num_rows > 0) {
            echo "<h2>Productos de $searchTerm</h2>";
            echo '<div class="row">';
            while ($row_product = $result_products->fetch_assoc()) {
                echo "<div class='col-md-4'>";
                echo "<div class='card mb-4'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row_product['nom'] . "</h5>";
                echo "<p class='card-text'>Precio: " . $row_product['preu'] . "€</p>";
                echo "<div class='imagen' style='text-align:center;'>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($row_product['foto']) . "' alt='' class='img-fluid'>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo '</div>';
        } else {
            echo "<p>No se encontraron productos para el usuario: $searchTerm</p>";
        }
    } else {
        echo "<p>No se encontró ningún usuario con el nombre: $searchTerm</p>";
    }

    $conn->close();
    ?>

</div>

<script>
    function validar() {
        var searchInput = document.getElementById('searchInput').value;
        if (searchInput.trim() === "") {
            return false;
        }
        return true;
    }
</script>
<script>
  var contadorCarrito = 0;

  function agregarAlCarrito(idProducto) {
      // Incrementa el contador
      contadorCarrito++;
      // Actualiza la interfaz
      document.getElementById("contadorCarrito").textContent = contadorCarrito;
      $.ajax({
          url: 'agregar_al_carrito.php',
          type: 'POST',
          data: { id: idProducto },
          success: function(response) {
              // Manejo de la respuesta si es necesario
          }
      });
  }
</script>

</body>
<footer>
      <div class="background">
        <div class="container">
          <div class="row general">
            <div class="col izquierda">
              <div class="row">
                <div class="col titulo">
                  <a class="navbar-brand" href="./../index.php">Couture<span>App</span></a>
                </div>
                <div class="col">
                  <a href="./../index.php">Avisos legales</a>
                </div>
                <div class="col">
                  <a href="./../index.php">Proteccion de datos</a>
                </div>
              </div>
            </div>
            <div class="col derecha">
              <div class="row">
                <div class="col-4">
                  <p>Síguenos por:</p>
                </div>
                <div class="col-3 rrss">
                  <a href="www.instagram.com"><i class="bi bi-instagram"></i></a>
                  <a href="www.facebook.com"><i class="bi bi-facebook"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
</html>
