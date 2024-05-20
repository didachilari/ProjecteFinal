<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$database = "couture";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    header("Location: pagina-usuario.php");
    exit();
}

$id_producto = $_GET['id'];

$sql = "SELECT id_producte, nom, preu, foto, id_marcas, categorias FROM producte WHERE id_producte = $id_producto";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "El producto no existe.";
    exit();
}

$producto = $result->fetch_assoc();

$sql_marcas = "SELECT id_marcas, nom FROM marcas";
$result_marcas = $conn->query($sql_marcas);

if (!$result_marcas) {
    echo "Error al obtener las marcas: " . $conn->error;
    exit();
}

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la nueva categoría del formulario
    $categoria = $_POST['categoria'];

    // Actualizar la categoría del producto en la base de datos
    $sql_update_categoria = "UPDATE producte SET categorias = '$categoria' WHERE id_producte = $id_producto";

    if ($conn->query($sql_update_categoria) === TRUE) {
        // Procesar la imagen si se proporcionó
        if ($_FILES['foto']['size'] > 0) {
            // Leer la imagen como datos binarios
            $imagen_temp = $_FILES['foto']['tmp_name'];
            $imagen_contenido = file_get_contents($imagen_temp);

            // Actualizar la imagen en la base de datos
            $sql_update_imagen = "UPDATE producte SET foto = ? WHERE id_producte = $id_producto";
            $stmt_update_imagen = $conn->prepare($sql_update_imagen);
            $stmt_update_imagen->bind_param("b", $imagen_contenido); // "b" para datos binarios

            if (!$stmt_update_imagen->execute()) {
                echo "Error al actualizar la imagen: " . $conn->error;
            }
        }
        
        // Redireccionar a alguna página o mostrar un mensaje de éxito
    } else {
        echo "Error al actualizar la categoría: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
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
                  <a class="nav-link active" aria-current="page" href="./html/pagina-usuario.php"><i class="bi bi-person-circle"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link nav-link-cart" href="./html/carrito.php"><i class="bi bi-cart"></i><span id="contadorCarrito" class="contador-carrito">0</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="./html/login.php"><i class="bi bi-house-door"></i></a>
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
            </ul>
          </div>
        </div>
      </nav>
    </header>


    <div class="container mt-5">
    <h1>Editar Producto</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $producto['nom'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" class="form-control" id="precio" name="precio" value="<?= $producto['preu'] ?>" min="0" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría:</label>
            <select id="categoria" name="categoria" class="form-select" required>
                <option value="">Selecciona una categoría</option>
                <option value="camiseta" <?= ($producto['categorias'] == 'camiseta') ? 'selected' : '' ?>>Camiseta</option>
                <option value="camisa" <?= ($producto['categorias'] == 'camisa') ? 'selected' : '' ?>>Camisa</option>
                <option value="pantalon" <?= ($producto['categorias'] == 'pantalon') ? 'selected' : '' ?>>Pantalon</option>
                <option value="abrigo" <?= ($producto['categorias'] == 'abrigo') ? 'selected' : '' ?>>Abrigo</option>
                <option value="calzado" <?= ($producto['categorias'] == 'calzado') ? 'selected' : '' ?>>Calzado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto:</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
