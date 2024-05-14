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
            <form class="d-flex" role="search" action="resultados_busqueda.php" method="GET">
              <button class="btn" type="submit"><i class="bi bi-search"></i></button>
              <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search" name="search">
            </form>
          </div>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="./html/pagina-usuario.php">Camisa</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./html/carrito.php">Camiseta</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./html/login.php">Pantalon</i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./html/login.php">Chaquetas</i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./html/login.php">Accesorios</i></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>




    <section class="vender">

      <div class="container">
        <img src="./img/img_index.png" alt="">
        <div class="frase-img">
          <h2>Empieza a vender en solo un click</h2>
        </div>
        <div class="boton-crear">
          <a href="./html/creacio-productes.php">Vender</a>
        </div>
      </div>
    </section>
    <section class="populares">
      <div class="container">
        <h2>Artículos populares</h2>
      <?php
      // Conexión a la base de datos
      $servername = "localhost";
      $username = "root";
      $password = "root";
      $database = "couture";

      $conn = new mysqli($servername, $username, $password, $database);

      // Verificar la conexión
      if ($conn->connect_error) {
          die("Conexión fallida: " . $conn->connect_error);
      }

      // Variable que almacena el término de búsqueda
      $searchTerm = $_GET['search'] ?? ''; // Si no se ha enviado un término de búsqueda, se asigna una cadena vacía

      // Consulta SQL para obtener los datos filtrados por el término de búsqueda
      $sql = "SELECT p.*, u.nom_usuari 
              FROM producte p 
              INNER JOIN usuario u ON p.id_usuari = u.id_usuari
              WHERE p.nom LIKE '%$searchTerm%'"; // Filtrar por el nombre del producto que contenga el término de búsqueda
      $result = $conn->query($sql);?>

      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <div class="row">
            <?php
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {?>
            <div class="swiper-slide">
              <div class="contenedor-articulo">
                <div class="usuario">
                    <img src="./img/user-line.svg" alt="">
                    <span class="n-usuario"><?php echo $row["nom_usuari"]; ?></span>
                </div>
                <div class="imagen" style="text-align:center;">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['foto']); ?>" alt="">
                </div>
                <div class="contenido">
                    <div class="row con-icon">
                        <div class="col-6">
                            <div class="c-1">
                                <span> Nombre: <?php echo $row["nom"]; ?></span>
                                <br>
                                <span> Precio: <?php echo $row["preu"]; ?>€</span>
                                <br>
                                <span><?php echo $row["me_gusta"]; ?></span>
                                <br>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="c-2">
                                <div class="row h-b">
                                    <button type="button" class="boton-corazon">
                                        <img src="./img/heart.svg" alt="">
                                    </button>
                                    <button type="button" class="boton-corazon" onclick="agregarAlCarrito(<?php echo $row["id_producte"]; ?>)">
                                        <img src="./img/bag.svg" alt="">
                                    </button>
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
          </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </div>
     
      <script>
      var contadorCarrito = 0;

      function agregarAlCarrito(idProducto) {
          // Incrementa el contador
          contadorCarrito++;
          // Actualiza el contador en la interfaz
          document.getElementById("contadorCarrito").textContent = contadorCarrito;
          $.ajax({
              url: 'agregar_al_carrito.php',
              type: 'POST',
              data: { id: idProducto },
              success: function(response) {
                  // Maneja la respuesta del servidor si es necesario
              }
          });
      }
      </script>
    </section>
    <footer>
      <div class="background">
        <div class="container">
          <div class="row general">
            <div class="col izquierda">
              <div class="row">
                <div class="col titulo">
                  <a class="navbar-brand" href="./index.php">CoutureApp</a>
                </div>
                <div class="col">
                  <a href="./index.php">Avisos legales</a>
                </div>
                <div class="col">
                  <a href="./index.php">Proteccion de datos</a>
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

    <script>
    var swiper = new Swiper(".mySwiper", {
      cssMode: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
      },
      mousewheel: true,
      keyboard: true,
    });
  </script>
</body>
</html>
