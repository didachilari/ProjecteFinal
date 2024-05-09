<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../style.css">
    <title>Carrito de Compras</title>
</head>
<body class="index">
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
                            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
                        </form>
                    <ul class="navbar-nav">
                      <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="pagina-usuario.php"><i class="bi bi-person-circle"></i></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-cart"></i></a>
                      </li>
                      <li class="nav-item">
                      <a class="nav-link" href="./../index.php"><i class="bi bi-house-door"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </nav>
        </div>
    </header>
    <section class="populares">
      <div class="container">
        <h2>Carrito</h2>
        <?php
        // Inicia la sesión para mantener los datos del carrito
        session_start();

        // Verifica si existe la variable de sesión 'carrito' y si contiene productos
        if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "couture";

            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Obtener los productos del carrito basados en los IDs almacenados en $_SESSION['carrito']
            $productosID = implode(',', array_map('intval', $_SESSION['carrito']));
            $sql = "SELECT p.*, u.nom_usuari
                    FROM producte p
                    INNER JOIN usuario u ON p.id_usuari = u.id_usuari
                    WHERE p.id_producte IN ($productosID)";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="productos">';
                while($row = $result->fetch_assoc()) {
                    echo '<div class="producto">';
                    echo '<p>Nombre: ' . $row['nom'] . ' - Precio: ' . $row['preu'] . '€</p>';
                    echo '<p>Usuario: ' . $row['nom_usuari'] . '</p>';
                    echo '<img src="data:image/jpeg;base64,'.base64_encode($row['foto']).'" alt="' . $row['nom'] . '" style="max-width: 100px;">'; // Establece el tamaño máximo de la imagen
                    // Agrega un formulario para eliminar el producto del carrito
                    echo '<form action="eliminar_producto.php" method="post">';
                    echo '<input type="hidden" name="id_producte" value="' . $row['id_producte'] . '">';
                    echo '<button type="submit" class="btn btn-danger">Eliminar</button>';
                    echo '</form>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo 'No hay productos en el carrito.';
            }

            $conn->close();
        } else {
            echo 'El carrito está vacío.';
        }
        ?>
      </div>
    </section>
</body>
</html>

