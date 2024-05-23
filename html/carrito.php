<?php
session_start();

include "./../functions/db_connection.php";

// Inicializar el carrito si está vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Inicializar la variable $total
$total = 0;

// Función para añadir productos al carrito
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id_producte'];
    // Añadir el producto al carrito
    $_SESSION['carrito'][] = $id;
}

// Función para eliminar un producto del carrito
if (isset($_POST['remove'])) {
    $id = $_POST['id_producte'];
    // Eliminar el producto del carrito
    $_SESSION['carrito'] = array_diff($_SESSION['carrito'], array($id));
}

// Función para finalizar la compra
if (isset($_POST['finalize'])) {
    $_SESSION['carrito'] = []; // Limpiar el carrito
    header('Location: finalizar_compra.php?total=' . $_POST['total']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="./../style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                <a class="nav-link" href="./../index.php"><i class="bi bi-house-door"></i></a>
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
                        <a class="nav-link" href="pantalon.php">Pantalón</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="chaquetas.php">Chaquetas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calzado.php">Calzado</a>
                    </li>
                </ul>
            </div>
        </div>
      </nav>
    </header>

<section class="populares">
    <div class="container">
        <h2>Carrito de Compras</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verifica si hay productos en el carrito
                if (!empty($_SESSION['carrito'])) {
                    // Obtiene los productos del carrito
                    $productosID = implode(',', $_SESSION['carrito']);
                    $sql = "SELECT * FROM producte WHERE id_producte IN ($productosID)";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $subtotal = $row['preu'];
                            $total += $subtotal;
                            $imageData = base64_encode($row['foto']);
                            $imageSrc = 'data:image/jpeg;base64,' . $imageData;

                            echo "<tr>
                                    <td><img src='{$imageSrc}' alt='{$row['nom']}' style='width: 100px; height: auto;'></td>
                                    <td>{$row['nom']}</td>
                                    <td>{$row['preu']}€</td>
                                    <td>
                                        <form action='' method='post'>
                                            <input type='hidden' name='id_producte' value='{$row['id_producte']}'>
                                            <button type='submit' name='remove' class='btn btn-danger'>Eliminar</button>
                                        </form>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo '<tr><td colspan="4">No hay productos en el carrito.</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">El carrito está vacío.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <h4>Total: <span id="total"><?= number_format($total, 2) ?>€</span></h4>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <form action="finalizar_compra.php" method="get">
                <input type="hidden" id="total_input" name="total" value="<?= number_format($total * 100, 0, '', '') ?>"> <!-- Multiplicamos el total por 100 para convertir a centavos -->
                <button type="submit" class="btn btn-primary">Finalizar Compra</button>
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
                            <a href="./../index.php">Protección de datos</a>
                        </div>
                    </div>
                </div>
                <div class="col derecha">
                    <div class="row">
                        <div class="col-4">
                            <p>Síguenos por:</p>
                        </div>
                        <div class="col-3 rrss">
                            <a href="https://www.instagram.com"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.facebook.com"><i class="bi bi-facebook"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
