<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./../style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
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
            //iniciarem la sessió
            session_start();
            //verificarem s'hi ha productes en el carrito
            if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                //connexió bbdd
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "couture";
                //crearem la connexió
                $conn = new mysqli($servername, $username, $password, $database);
                //verificarem la connexió
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                //obtindrem els productes del carrito
                $productosID = ''; //iniciarem una cadena buida
                foreach($_SESSION['carrito'] as $id) {
                    $productosID .= $id . ','; //afegerirem cada ID seguida per una coma a la cadena
                }
                $productosID = rtrim($productosID, ','); //el rtrim, és per eliminar l'ultima coma de la cadena
                $sql = "SELECT p.*, u.nom_usuari FROM producte p INNER JOIN usuario u ON p.id_usuari = u.id_usuari WHERE p.id_producte IN ($productosID)";
                $result = $conn->query($sql);
                //mostrarem els productes
                if ($result->num_rows > 0) {
                    echo '<div class="productos">';
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="producto">';
                        echo '<p>Nombre: ' . $row['nom'] . ' - Precio: ' . $row['preu'] . '€</p>';
                        echo '<p>Usuario: ' . $row['nom_usuari'] . '</p>';
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($row['foto']).'" alt="' . $row['nom'] . '" style="max-width: 100px;">';
                        //aqui farem un formulari per eliminar el producte
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
