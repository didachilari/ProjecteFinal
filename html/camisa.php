<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Resultados de Búsqueda</title>
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
            <a class="nav-link" aria-current="page" href="./camisa.php">Camisa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./camiseta.php">Camiseta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pantalon.php">Pantalon</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./chaquetas.php">Chaquetas</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./calzado.php">Calzado</i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<?php
// Iniciar sesión
session_start();

include "./../functions/db_connection.php";

// Realizar consulta SQL para obtener productos de la categoría "Camisa"
$sql = "SELECT p.*, u.nom_usuari 
    FROM producte p 
    INNER JOIN usuario u ON p.id_usuari = u.id_usuari
    WHERE categorias LIKE '%Camisa%'"; // Filtro por el nombre que contenga el artículo que hemos puesto en el buscador
$result = $conn->query($sql);
?>
<section class="camisa">
    <div class="margin-top-80-30">
        <div class="container">
            <?php if ($result->num_rows > 0) {?>
                <div class="row">
                <?php foreach ($result as $row) { ?>
                    <div class="col-lg-3 col-md-4">
                        <div class="contenedor-articulo">
                            <div class="usuario">
                                <img src="./../img/user-line.svg" alt="">
                                <span class="n-usuario"><?php echo $row["nom_usuari"]; ?></span>
                            </div>
                            <button type="button" class="boton-corazon" data-id="<?php echo $row['id_producte']; ?>">
                                <img src="./../img/heart.svg" alt="">
                            </button>
                            <div class="imagen" style="text-align:center;">
                            <a href="./html/detalle_producto.php?id=<?php echo $row['id_producte']; ?>">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['foto']); ?>" alt="">
                                </a>
                            </div>
                            <div class="contenido">
                                <div class="row con-icon">
                                    <div class="col-10">
                                        <div class="c-1">
                                            <span><?php echo $row["nom"]; ?></span>
                                            <br>
                                            <span> Precio: <?php echo $row["preu"]; ?>€</span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="col-2 carro">
                                        <div class="carrito">
                                            <div class="row h-b">
                                                <button type="button" class="boton-carro" onclick="agregarAlCarrito(<?php echo $row['id_producte']; ?>)">
                                                    <img src="./../img/bag.svg" alt="">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            <?php
            } else {
                echo "0 resultados";
            }
            // Cerrar la conexión
            $conn->close();
            ?>
        </div>
    </div>
</section>
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
              <a href="https://www.instagram.com"><i class="bi bi-instagram"></i></a>
              <a href="https://www.facebook.com"><i class="bi bi-facebook"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer><script>
  var contadorCarrito = 0;

  function agregarAlCarrito(idProducto) {
      //incrementa el contador
      contadorCarrito++;
      //actualitza l'interfaç
      document.getElementById("contadorCarrito").textContent = contadorCarrito;
      $.ajax({
          url: '../functions/agregar_al_carrito.php',
          type: 'POST',
          data: { id: idProducto },
          success: function(response) {
          }
      });
  }
</script>
<script>
function validar() {
    var searchInput = document.getElementById('searchInput').value;
    if (searchInput.trim() === "") {
        // Evita que el formulario se envíe si el campo de búsqueda está vacío
        return false;
    }
    // Permite que el formulario se envíe si hay texto en el campo de búsqueda
    return true;
    
}
</script>
</body>
</html>
