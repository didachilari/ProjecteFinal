<<<<<<< HEAD
<?php
session_start();

// Establecer conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "couture";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

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

// Función para aumentar la cantidad de un producto en el carrito
if (isset($_POST['increase'])) {
    $id = $_POST['id_producte'];
    // Aumentar la cantidad del producto en el carrito
    $_SESSION['carrito'][] = $id;
}

// Función para disminuir la cantidad de un producto en el carrito
if (isset($_POST['decrease'])) {
    $id = $_POST['id_producte'];
    // Encontrar el índice del producto en el carrito
    $index = array_search($id, $_SESSION['carrito']);
    if ($index !== false) {
        // Disminuir la cantidad del producto en el carrito
        unset($_SESSION['carrito'][$index]);
    }
}

// Función para finalizar la compra
if (isset($_POST['finalize'])) {
    $_SESSION['carrito'] = []; // Limpiar el carrito
    // Redirige al formulario de pago y pasa el total del carrito como un parámetro en la URL
    header("Location: CreateCharge.php?total=$total");
    exit();
}
?>
=======
>>>>>>> parent of 145bb5a (carrito)
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
    <script src="https://js.stripe.com/v3/"></script>
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
<<<<<<< HEAD
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="buscador">
                <form class="d-flex" role="search" action="resultados_busqueda.php" method="GET">
                    <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                    <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search" name
                    ="search">
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
=======
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
>>>>>>> parent of 145bb5a (carrito)
        </div>
      </nav>
    </header>

    <section class="populares">
        <div class="container">
            <h2>Carrito</h2>
            <?php
            // PHP para mostrar los productos en el carrito
            // Inicia la sesión
            session_start();
            // Verifica si hay productos en el carrito
            if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                // Conexión a la base de datos
                $servername = "localhost";
                $username = "root";
                  $password = "";

<<<<<<< HEAD
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $subtotal = $row['preu'];
                            $total += $subtotal;
                            echo "<tr>
                                    <td>{$row['nom']}</td>
                                    <td id='precio_{$row['id_producte']}'>{$row['preu']}€</td>
                                    <td
                                    <td>
                                    <div class='input-group'>
                                        <input type='number' id='cantidad_{$row['id_producte']}' min='1' max='10' step='1' value='1' size='5' onchange='actualizaCantidad(this.value, {$row['id_producte']})'>
                                    </div>
                                </td>
                                <td id='subtotal_{$row['id_producte']}'>{$subtotal}€</td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='hidden' name='id_producte' value='{$row['id_producte']}'>
                                        <button type='submit' name='remove' class='btn btn-danger'>Eliminar</button>
                                    </form>
                                </td>
                                </tr>";
                                }
                                } else {
                                echo '<tr><td colspan="5">No hay productos en el carrito.</td></tr>';
                                }
                                } else {
                                echo '<tr><td colspan="5">El carrito está vacío.</td></tr>';
                                }
                                ?>
                                </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    <h4>Total: <span id="total"><?= number_format($total, 2) ?>€</span></h4>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <form action="" method="post">
                                        <button type="button" onclick="finalizarCompra()" class="btn btn-primary">Finalizar Compra</button>
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
                                
                                <script>
                                function actualizaCantidad(cantidad, id) {
                                    // Realizar la actualización solo si la cantidad es válida
                                    if (cantidad >= 1 && cantidad <= 10) {
                                        // Obtener el precio unitario del producto
                                        let precioUnitario = parseFloat(document.getElementById('precio_' + id).innerText);
                                        // Calcular el nuevo subtotal
                                        let subtotal = cantidad * precioUnitario;
                                        // Actualizar el subtotal en la tabla
                                        document.getElementById('subtotal_' + id).innerText = subtotal.toFixed(2) + '€';
                                        // Recalcular el total
                                        recalcularTotal();
                                    } else {
                                        alert("La cantidad debe ser un número entre 1 y 10.");
                                        // Restaurar la cantidad anterior
                                        document.getElementById('cantidad_' + id).value = 1;
                                    }
                                }
                                
                                function recalcularTotal() {
                                    let total = 0;
                                    // Obtener todos los subtotales y sumarlos para calcular el total
                                    let subtotales = document.querySelectorAll('[id^="subtotal_"]');
                                    subtotales.forEach(subtotal => {
                                        total += parseFloat(subtotal.innerText);
                                    });
                                    // Actualizar el total en la página
                                    document.getElementById('total').innerText = total.toFixed(2) + '€';
                                }
                                
                                function finalizarCompra() {
    var stripeHTML = `<form action="CreateCharge.php" method="post" id="payment-form">
                            <div class="form-row">
                                <label for="name">Nombre</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="form-row">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-row">
                                <label for="phone">Teléfono</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                            <div class="form-row">
                                <label for="address">Dirección</label>
                                <input type="text" id="address" name="address" required>
                            </div>
                            <div class="form-row">
                                <label for="card-element">Tarjeta de Crédito o Débito</label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                            <button type="submit">Pagar</button>
                            <div id="total-container" style="display: none;">
                                <h4>Total: <span id="total-pago"><?= number_format($total, 2) ?>€</span></h4>
                            </div>
                        </form>`;

    // Mostrar el formulario de pago en un cuadro de diálogo de alerta
    alert(stripeHTML);

    // Mostrar el total después de 3 segundos
    setTimeout(function() {
        document.getElementById('total-container').style.display = 'block';
    }, 3000);
}

                                </script>
                                
                                </body>
                                </html>
                                
=======

                $database = "couture";
                // Crea la conexión
                $conn = new mysqli($servername, $username, $password, $database);
                // Verifica la conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                // Obtiene los productos del carrito
                $productosID = '';
                foreach($_SESSION['carrito'] as $id) {
                    $productosID .= $id . ',';
                }
                $productosID = rtrim($productosID, ','); // Elimina la última coma
                $sql = "SELECT p.*, u.nom_usuari FROM producte p INNER JOIN usuario u ON p.id_usuari = u.id_usuari WHERE p.id_producte IN ($productosID)";
                $result = $conn->query($sql);
                // Muestra los productos
                if ($result->num_rows > 0) {
                    echo '<div class="productos">';
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="producto">';
                        echo '<p>Nombre: ' . $row['nom'] . ' - Precio: ' . $row['preu'] . '€</p>';
                        echo '<p>Usuario: ' . $row['nom_usuari'] . '</p>';
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($row['foto']).'" alt="' . $row['nom'] . '" style="max-width: 100px;">'; // Establece el tamaño máximo de la imagen
                        // Formulario para eliminar producto del carrito
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
>>>>>>> parent of 145bb5a (carrito)
