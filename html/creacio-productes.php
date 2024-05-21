<?php
// Iniciar sesión
session_start();

include "./../functions/db_connection.php";

// Obtener marcas de la base de datos
$sql_marcas = "SELECT id_marcas, nom FROM marcas";
$result_marcas = $conn->query($sql_marcas);
$marcas = [];
if ($result_marcas->num_rows > 0) {
    while ($row = $result_marcas->fetch_assoc()) {
        $marcas[$row["id_marcas"]] = $row["nom"];
    }
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del usuario de la sesión
    if(isset($_SESSION['id_usuario'])) {
        $id_usuario = $_SESSION['id_usuario'];
    } else {
        die("Error: Sesión de usuario no encontrada.");
    }

    // Obtener los datos del formulario
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"]; // Obtener la categoría seleccionada
    $precio = $_POST["precio"];
    $imagen = $_FILES["imagen"]["tmp_name"];
    $marca = $_POST["marca"]; 

    //leer contenido binario de la img
    $imagenBinaria = file_get_contents($imagen);

    //escapar el contenido binario para evitar problemas de codificación
    $imagenBinariaEscapada = $conn->real_escape_string($imagenBinaria); 

    //preparar la consulta sql
    $sql = "INSERT INTO producte (nom, preu, foto, categorias, id_usuari, id_marcas) VALUES ('$titulo', '$precio', '$imagenBinariaEscapada', '$categoria', $id_usuario, $marca)";

    //ejectuar la consulta
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "<script>alert('Error al crear el producto: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Productos</title>

    <!-- Enlaces a hojas de estilo -->
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


    <section class="form-producto">
        <div class="container">
            <h2 class="my-5">Pujar artículo</h2>
            <div class="formulario">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="my-3">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*" required>
                    </div>
                    <div class="my-3">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" required>
                    </div>
                    <div class="my-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" class="form-control" required></textarea>
                    </div>
                    <div class="my-3">
                        <label for="categoria" class="form-label">Categoría:</label>
                        <select id="categoria" name="categoria" class="form-select" required>
                            <option value="">Selecciona una categoría</option>
                            <option value="camiseta">Camiseta</option>
                            <option value="camisa">Camisa</option>
                            <option value="pantalon">Pantalon</option>
                            <option value="abrigo">Abrigo</option>
                            <option value="calzado">Calzado</option>
                        </select>
                    </div>
                    <div class="my-3">
                        <label for="marca" class="form-label">Marca:</label>
                        <select id="marca" name="marca" class="form-select" required>
                            <option value="">Selecciona una marca</option>
                            <?php
                            foreach ($marcas as $id => $marca) {
                                echo "<option value='$id'>$marca</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="my-3">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" id="precio" name="precio" min="0" step="0.01" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Crear Producto</button>
                    <a href="../index.php" class="btn btn-secundary">Tornar</a>
                </form>
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
