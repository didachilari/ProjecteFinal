<?php
//iniciarem la sessió
session_start();

include "./../functions/db_connection.php";

//verificarem s'hi s'ha enviat el formulari
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //obtindrem les dades del formulari
    $nombre = $_POST["nombre"];
    
    //verificarem s'hi s'ha enviat la foto de la marca
    if (isset($_FILES["foto"])) {
        $foto = $_FILES["foto"]["tmp_name"];

        //leegirem el contingut de la imatge en forma binaria
        $fotoBinaria = file_get_contents($foto);

        //escapaerem el contingut binari per evitar els problemes de codificació
        $fotoBinariaEscapada = $conn->real_escape_string($fotoBinaria);

        //farem una consulta a la bbdd per insertar la marca que em creat
        $sql = "INSERT INTO marcas (nom, foto_marca) VALUES ('$nombre', '$fotoBinariaEscapada')";

        //executar la consulta
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Marca agregada correctamente');</script>";
        } else {
            echo "<script>alert('Error al agregar la marca: " . $conn->error . "');</script>";
        }
    } else {
        //error si no em escollit cap imatge per al producte
        echo "<script>alert('Por favor, seleccione una foto.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Marca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="creacio">
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
                <a class="nav-link" href="./login.php"><i class="bi bi-house-door"></i></a>
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
                <a class="nav-link" aria-current="page" href="camisa.php">Camisa</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="camiseta.php">Camiseta</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pantalon.php">Pantalon</i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="chaquetas.php">Chaquetas</i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="calzado.php">Calzado</i></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>


    <div class="container mt-5">
        <h2 class="mb-4">Agregar Marca</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre de la Marca:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto de la Marca:</label>
                <input type="file" class="form-control-file" id="foto" name="foto" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="creacio-productes.php" class="btn btn-secondary">Tornar</a>
        </form>
    </div>
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
</body>
</html>

