<?php
session_start();
include '../functions/db_connection.php';

$id_marca = $_GET['id'];

// Consulta SQL para obtener los productos de la marca seleccionada
$sql = "SELECT p.*, u.nom_usuari 
        FROM producte p 
        INNER JOIN usuario u ON p.id_usuari = u.id_usuari
        WHERE p.id_marcas = $id_marca";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../style.css">
<title>Productos de la Marca</title>
</head>
<body class="productos-marca">
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
          <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" name="search" id="searchInput">        </form>
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
<section class="productos-marca margin-top-80-30">
  <div class="container">
    <h2>Productos de la Marca</h2>
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <?php
        if ($result->num_rows > 0) {
          foreach ($result as $row) { ?>
            <div class="swiper-slide">
              <div class="contenedor-articulo">
                <div class="usuario">
                  <img src="../img/user-line.svg" alt="">
                  <span class="n-usuario"><?php echo $row["nom_usuari"]; ?></span>
                </div>
                <button type="button" class="boton-corazon" data-id="<?php echo $row['id_producte']; ?>">
                  <img src="../img/heart.svg" alt="">
                </button>
                <div class="imagen" style="text-align:center;">
                  <a href="./detalle_producto.php?id=<?php echo $row['id_producte']; ?>">
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
                            <img src="../img/bag.svg" alt="">
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php }
        } else {
          echo "No hay productos para esta marca.";
        }
        $conn->close();
        ?>
      </div>
      <div class="swiper-button-next">
        <i class="bi bi-arrow-right"></i>
      </div>
      <div class="swiper-button-prev">
        <i class="bi bi-arrow-left"></i>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>
<script>
var swiper = new Swiper('.mySwiper', {
    slidesPerView: 3,
    spaceBetween: 20,
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});
</script>
<script>
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
</body>
</html>
