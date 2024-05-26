<?php
session_start();
$id_usuario = $_SESSION['id_usuario'];
include './functions/db_connection.php';
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
          <a class="navbar-brand" href="./index.php">Couture<span>App</span></a>
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
              <a class="nav-link" href="./html/logout.php"><i class="bi bi-box-arrow-right"></i></a>
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
        <form class="d-flex" role="search" action="./html/resultados_busqueda.php" method="GET" onsubmit="return validar()">
          <button class="btn" type="submit"><i class="bi bi-search"></i></button>
          <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" name="search" id="searchInput">
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
<section class="vender margin-top-80-30">
<img src="./img/img_index.png" alt="">

  <div class="container">
    <div class="frase-img">
      <h2>Empieza a vender en solo un click</h2>
    </div>
    <div class="boton-crear">
      <a href="./html/creacio-productes.php">Vender</a>
    </div>
  </div>
</section>
<section class="populares margin-top-80-30">
  <div class="container">
    <h2>Artículos populares</h2>
    <?php

$searchTerm = $_GET['search'] ?? '';

      //farem la consulta
      $sql = "SELECT p.*, u.nom_usuari, m.nom AS nom_marca
        FROM producte p 
        INNER JOIN usuario u ON p.id_usuari = u.id_usuari
        INNER JOIN marcas m ON p.id_marcas = m.id_marcas
        WHERE p.nom LIKE '%$searchTerm%'";
        $result = $conn->query($sql);
?>
<div class="swiper mySwiper">
    <div class="swiper-wrapper">
  <?php
  if ($result->num_rows > 0) {
      foreach ($result as $row) { ?>
    <div class="swiper-slide">
        <div class="contenedor-articulo">
      <div class="usuario">
          <img src="./img/user-line.svg" alt="">
          <span class="n-usuario"><?php echo $row["nom_usuari"]; ?></span>
      </div>
      <?php include './functions/db_connection.php'; ?>
      <a href="./html/detalle_producto.php?id=<?php echo $row['id_producte']; ?>">
          <div class="imagen" style="text-align:center;">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['foto']); ?>" alt="">
          </div>
      </a>
      <div class="contenido">
          <div class="row con-icon">
        <div class="col-10">
            <div class="c-1">
          <p><?php echo $row["nom"]; ?></p>
          <p><span>Marca:</span> <?php echo $row["nom_marca"]; ?></p>
          <p><span>Talla:</span> <?php echo $row["talla"]; ?></p> <!-- Añadido aquí -->
          <p><span>Precio:</span> <?php echo $row["preu"]; ?>€</p>
            </div>
        </div>
        <div class="col-2 carro">
            <div class="carrito">
          <div class="row h-b">
              <button type="button" class="boton-carro" onclick="agregarAlCarrito(<?php echo $row['id_producte']; ?>)">
            <img src="./img/bag.svg" alt="">
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
      echo "0 resultados";
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
</section>

<section class="marcas margin-top-80-30">
  <div class="background-claro">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 contenido">
          <h2>Encuentra tu marca</h2>
          <p>Todas tus marcas favoritas en un solo click</p>
        </div>
        <div class="col-lg-6 imagenes">
          <div class="imagen">
            <img src="./img/polo.png" alt="modelo polo">
          </div>
          <div class="imagen">
            <img src="./img/polo2.png" alt="modelo polo2">
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
    include './functions/db_connection.php';
    $sql1 = "SELECT id_marcas, nom, foto_marca FROM marcas";
    $result2 = $conn->query($sql1);
  ?>

  <div class="background-oscuro">
    <div class="container">
    <div class="swiper mySwiper2">
      <div class="swiper-wrapper">
        <?php foreach ($result2 as $marca){ ?>
          <div class="swiper-slide contenedor-marca">
            <a href="./html/productos_marca.php?id=<?php echo $marca['id_marcas']; ?>">
              <div class="imagen-marca">
                <?php if (!empty ($marca['foto_marca'])){ ?>
                    <img src="data:image/png;base64,<?php echo base64_encode($marca['foto_marca']); ?>" alt="Foto Marca">
                <?php } else { ?>
                  <a href="./html/productos_marca.php?id=<?php echo $marca['id_marcas']; ?>">No image</a>
                <?php } ?>
              </div>
            </a>
            <div class="nombre-marca">
              <span>
                <a href="./html/productos_marca.php?id=<?php echo $marca['id_marcas']; ?>">
                  <?php echo $marca['nom']; ?>
                </a>
              </span>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="swiper-button-next">
        <i class="bi bi-arrow-right"></i>
      </div>
      <div class="swiper-button-prev">
        <i class="bi bi-arrow-left"></i>
      </div>
    </div>
    </div>
  </div>
</section>


<section class="categorias margin-top-80-30">
  <div class="background-black">
  <div class="container">
      <div class="row">
        <div class="col-lg-6 contenido">
          <h2>Descubre tu estilo</h2>
        </div>
          <div class="col-lg-6 video">
            <div class="videos">
              <video src="./img/anuncio.mp4" autoplay muted playsinline>
              </video>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="categoria">
    <div class="background-semiblack">
      <div class="container">
        <div class="swiper mySwiper3">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <a href="./html/camiseta.php">
                <div class="imagen">
                  <img src="./img/camiseta.webp" alt="categoria camiseta">
                </div>
              </a>
              <a href="./html/camiseta.php">Camiseta</a>
            </div>
            <div class="swiper-slide">
              <a href="./html/pantalon.php">
                <div class="imagen">
                  <img src="./img/pantalones.webp" alt="categoria camiseta">
                </div>
              </a>
              <a href="./html/pantalon.php">Pantalon</a>
            </div>
            <div class="swiper-slide">
              <a href="./html/calzado.php">
                <div class="imagen">
                  <img src="./img/calzado.webp" alt="">
                </div>
              </a>
              <a href="./html/calzado.php">Calzado</a>
            </div>
            <div class="swiper-slide">
              <a href="./html/chaquetas.php">
                <div class="imagen">
                  <img src="./img/chaqueta.webp" alt="">
                </div>
              </a>
              <a href="./html/chaquetas.php">Chaquetas</a>
            </div>
            <div class="swiper-slide">
              <a href="./html/camisa.php">
                <div class="imagen">
                  <img src="./img/camisa.webp" alt="">
                </div>
              </a>
              <a href="./html/camisa.php">Camisa</a>
            </div>
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
    </div>
  </section>
  
<footer>
  <div class="background">
    <div class="container">
      <div class="row general">
        <div class="col izquierda">
          <div class="row">
            <div class="col titulo">
              <a class="navbar-brand" href="./index.php">Couture<span>App</span></a>
            </div>
            <div class="col">
              <a href="./html/avis_legal.html">Avisos legales</a>
            </div>
            <div class="col">
              <a href="./index.php">Proteccion de datos</a>
            </div>
          </div>
        </div>
        <div class="col derecha">
          <div class="row">
            <div class="col-lg-4">
              <p>Síguenos por:</p>
            </div>
            <div class="col-lg-3 rrss">
              <a href="https://www.instagram.com"><i class="bi bi-instagram"></i></a>
              <a href="https://www.facebook.com"><i class="bi bi-facebook"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<script>
var swiper = new Swiper('.mySwiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    breakpoints: {
        770: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 0,
        },
      },
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
var swiper = new Swiper(".mySwiper2", {
  slidesPerView: 1,
    spaceBetween: 50,
    loop: true,
    breakpoints: {
        770: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 50,
        },
      },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});
</script>
<script>
var swiper = new Swiper(".mySwiper3", {
  slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    breakpoints: {
        770: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 50,
        },
      },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
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
        url: './../functions/agregar_al_carrito.php',
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
<!-- <script>
function me_gusta(id_producte) {
    $.ajax({
        url: './functions/me_gusta.php', // Cambia 'ruta_a_tu_php/me_gusta.php' por la ruta correcta
        type: 'POST',
        data: { id_producte: id_producte },
        success: function(response) {
            console.log("Respuesta del servidor:", response);  // Mostrar la respuesta completa en la consola
            try {
                var result = JSON.parse(response);
                alert(result.message); // Muestra el mensaje recibido del servidor
            } catch (e) {
                console.error("Error al parsear JSON:", e);
                console.error("Respuesta recibida:", response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud Ajax:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
        }
    });
}
</script> -->
</body>
</html>