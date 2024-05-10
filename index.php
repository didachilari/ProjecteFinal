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
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
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
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // Mostrar los datos obtenidos
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
              // Aquí puedes agregar más detalles del producto si lo deseas
              echo '</div>';
              echo '</div>';
              echo '<div class="col-6">';
              echo '<div class="c-2">';
              echo '<div class="row h-b">';
              echo '<button type="button" class="boton-corazon">
                    <img src="./img/heart.svg" alt="">
                    </button>';
                    echo '<button type="button" class="boton-corazon" onclick="agregarAlCarrito(' . $row["id_producte"] . ')">
                    <img src="./img/bag.svg" alt="">
                </button>';
          
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
          }
      } else {
          echo "0 resultados";
      }
      $conn->close();
      ?>
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
</body>
</html>
