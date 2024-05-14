<?php
// Iniciar sesión
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "couture";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

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

    // Leer el contenido binario de la imagen
    $imagenBinaria = file_get_contents($imagen);

    // Escapar el contenido binario para evitar problemas de codificación
    $imagenBinariaEscapada = $conn->real_escape_string($imagenBinaria);

    // Preparar la consulta SQL con el contenido binario de la imagen
    $sql = "INSERT INTO producte (nom, preu, foto, categorias, me_gusta, id_usuari, id_marcas) VALUES ('$titulo', '$precio', '$imagenBinariaEscapada', '$categoria', 0, $id_usuario, $marca)";

    // Ejecutar la consulta
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
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                  <a class="navbar-brand" href="#">CoutureApp</a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                        <button class="btn btn-outline-primary " type="submit"><i class="bi bi-search"></i> Buscar</button>
                      </form>
                    <ul class="navbar-nav">
                      <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="pagina-usuario.php"><i class="bi bi-person-circle"></i></a>
                      </li>
                      <li class="nav-item">
                      <a class="nav-link" href="./../index.php"><i class="bi bi-cart"></i></a>
                      </li>
                      <li class="nav-item">
                      <a class="nav-link" href="login.php"><i class="bi bi-house-door"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </nav>
        </div>
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
</body>
</html>
