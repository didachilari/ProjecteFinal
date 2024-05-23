<?php
// Inicia la sesión para acceder a los datos del carrito
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario autenticado
$id_usuario = $_SESSION['id_usuario'];

include "./../functions/db_connection.php";

// Obtener los productos del usuario con el nombre de la marca
$sql = "SELECT p.id_producte, p.nom, p.preu, p.foto, m.nom AS nombre_marca, p.categorias 
        FROM producte p 
        INNER JOIN marcas m ON p.id_marcas = m.id_marcas 
        WHERE p.id_usuari = $id_usuario";
$result = $conn->query($sql);

// Array para almacenar los productos del usuario
$productos_usuario = [];

// Obtener los productos del resultado de la consulta
while ($row = $result->fetch_assoc()) {
    $productos_usuario[] = $row;
}

// Función para eliminar un producto
if (isset($_POST['eliminar_producto'])) {
    $id_producto = $_POST['eliminar_producto'];

    $sql = "DELETE FROM producte WHERE id_producte = $id_producto AND id_usuari = $id_usuario";
    $conn->query($sql);

    // Redirigir para evitar reenvío de formulario
    header("Location: pagina-usuario.php");
    exit();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Usuario</title>
    <!-- Enlaces a hojas de estilo -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="usuario">
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
                <li class="nav-item">
                  <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i></a>
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
        <h2>Mis Productos</h2>
        <!-- Mostrar los productos del usuario -->
        <?php if (count($productos_usuario) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Precio</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos_usuario as $producto): ?>
                        <tr>
                            <td><?php echo $producto['nom']; ?></td>
                            <td><?php echo $producto['preu']; ?></td>
                            <td><?php echo $producto['nombre_marca']; ?></td>
                            <td><?php echo $producto['categorias']; ?></td>
                            <td>
                                <?php if(isset($producto['foto']) && !empty($producto['foto'])): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['foto']); ?>" alt="imagen producto">
                                <?php else: ?>
                                    <p>No disponible</p>
                                <?php endif; ?>
                            </td>
                            <td class="buttons">
                                <form action="" method="POST">
                                    <input type="hidden" name="eliminar_producto" value="<?php echo $producto['id_producte']; ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                                <a href="editar-productes.php?id=<?php echo $producto['id_producte']; ?>" class="btn btn-primary">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tienes ningún producto aún.</p>
        <?php endif; ?>
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
