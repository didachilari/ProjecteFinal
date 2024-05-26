<?php
include "./../functions/db_connection.php";

//obtindrem la ID del producte
$productId = $_GET['id'];

//farem una consulta a la bbdd per mostrar els detalls del producte
$sql = "SELECT p.*, u.nom_usuari, m.nom AS nom_marca
        FROM producte p
        INNER JOIN usuario u ON p.id_usuari = u.id_usuari
        INNER JOIN marcas m ON p.id_marcas = m.id_marcas
        WHERE p.id_producte = $productId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Producto no encontrado";
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Detalle del Producto</title>
    <link rel="stylesheet" href="./../style.css">
</head>
<body class="detalls">
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
                  <a class="nav-link" href="./logout.php"><i class="bi bi-box-arrow-right"></i></a>
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

    <div class="container">
        <section class="producto">
            <div class="titulo">
                <h1>Detalles del Producto</h1>
            </div>
            <div class="columna">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="imagen-producto">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['foto']); ?>" alt="Imagen del Producto">
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-2">
                        <div class="detalles-productos">
                            <div class="detalles">
                                <h2><?php echo $row['nom']; ?></h2>
                                <p><strong>Descripción:</strong> <?php echo $row['descripcio']; ?></p>
                                <p><strong>Precio:</strong> <?php echo $row['preu']; ?>€</p>
                                <p><strong>Categoría:</strong> <?php echo $row['categorias']; ?></p>
                                <p><strong>Marca:</strong> <?php echo $row['nom_marca']; ?></p>
                                <p><strong>Talla:</strong> <?php echo $row['talla']; ?></p>
                                <p><strong>Subido por:</strong> <?php echo $row['nom_usuari']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- <section class="productos-relacionados">
            <?php
            // Consulta para obtener los productos relacionados
            $relatedSql = "SELECT p.*, u.nom_usuari, m.nom AS nom_marca
                           FROM producte p
                           INNER JOIN usuario u ON p.id_usuari = u.id_usuari
                           INNER JOIN marcas m ON p.id_marcas = m.id_marcas
                           WHERE p.id_usuari = {$row['id_usuari']}
                           ORDER BY RAND()
                           LIMIT 4";

            $relatedResult = $conn->query($relatedSql);
            if ($relatedResult->num_rows > 0) {
                while ($relatedRow = $relatedResult->fetch_assoc()) {
                    // Mostrar los productos relacionados
                    echo '<div class="producto-relacionado">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($relatedRow['foto']) . '" alt="Imagen del Producto">';
                    echo '<h3>' . $relatedRow['nom'] . '</h3>';
                    echo '<p><strong>Precio:</strong> ' . $relatedRow['preu'] . '€</p>';
                    echo '</div>';
                }
            } else {
                echo 'No se encontraron productos relacionados';
            }
            ?>
        </section>-->
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
                <div class="col-lg-4">
                  <p>Síguenos por:</p>
                </div>
                <div class="col-lg-3 rrss">
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
