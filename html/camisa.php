<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../style.css">
    <title>Seccion Camisa</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>
<body class="secciones">
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
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="buscador">
        <form class="d-flex" role="search" action="./resultados_busqueda.php" method="GET" onsubmit="return validar()">
          <button class="btn" type="submit"><i class="bi bi-search"></i></button>
          <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" name="search" id="searchInput">
        </form>
      </div>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="">Camisa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./camiseta.php">Camiseta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pantalon.php">Pantalon</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./chaquetas.php">Chaquetas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./calzado.php">Calzado</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<?php
//iniciarem la sessió
session_start();

include "./../functions/db_connection.php";
//farem un select per a que pugi mostrar el nom del usuari, el nom de la marca de la taula productes i una categoria especifica que es la de 'camisa'
$sql = "SELECT p.*, u.nom_usuari, m.nom AS nom_marca
    FROM producte p 
    INNER JOIN usuario u ON p.id_usuari = u.id_usuari
    INNER JOIN marcas m ON p.id_marcas = m.id_marcas
    WHERE categorias LIKE '%Camisa%'";
$result = $conn->query($sql);
?>
<main>
    <section class="camisa">
      <div class="margin-top-80-30">
          <div class="container">
            <h2>Seccion Camisa</h2>
              <?php if ($result->num_rows > 0) {?>
                  <div class="row">
                  <!-- amb un foreach recorrerem els productes que siguin de la categoria camisa -->
                  <?php foreach ($result as $row) { ?>
                      <div class="col-lg-3 col-6">
                          <div class="contenedor-articulo">
                              <div class="usuario">
                                  <img src="./../img/user-line.svg" alt="">
                                  <span class="n-usuario"><?php echo $row["nom_usuari"]; ?></span>
                              </div>
                              <button type="button" class="boton-corazon" data-id="<?php echo $row['id_producte']; ?>">
                                  <img src="./../img/heart.svg" alt="">
                              </button>
                              <div class="imagen" style="text-align:center;">
                              <a href="./detalle_producto.php?id=<?php echo $row['id_producte']; ?>">
                                      <img src="data:image/jpeg;base64,<?php echo base64_encode($row['foto']); ?>" alt="">
                                  </a>
                              </div>
                              <div class="contenido">
                                  <div class="row con-icon">
                                      <div class="col-10">
                                          <div class="c-1">
                                            <p><?php echo $row["nom"]; ?></p>
                                            <p><span>Marca:</span> <?php echo $row["nom_marca"]; ?></p>
                                            <p><span>Talla:</span> <?php echo $row["talla"]; ?></p> <!-- Añadido aquí -->
                                            <p><span>Precio:</span> <?php echo $row["preu"]; ?>€</p>
                                          </div>
                                      </div>
                                      <div class="col-2 carro">
                                          <div class="carrito">
                                              <div class="row h-b">
                                                  <button type="button" class="boton-carro" onclick="agregarAlCarrito(<?php echo $row['id_producte']; ?>)">
                                                      <img src="./../img/bag.svg" alt="">
                                                  </button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php } ?>
                  </div>
              <?php
              // si no hi ha cap productes amb aquesta caregoria que mostri això
              } else {
                  echo "0 resultados";
              }
              //tancarem la sessió
              $conn->close();
              ?>
          </div>
      </div>
  </section>
</main>

<footer>
  <div class="background">
    <div class="container">
      <div class="row general">
        <div class="col izquierda">
          <div class="row">
            <div class="col titulo">
              <a class="navbar-brand" href="./index.php">Couture<span>App</span></a>
            </div>
            <div class="col">
              <a href="./html/avis_legal.html">Avisos legales</a>
            </div>
            <div class="col">
              <a href="./index.php">Proteccion de datos</a>
            </div>
          </div>
        </div>
        <div class="col derecha">
          <div class="row">
            <div class="col-lg-4">
              <p>Síguenos por:</p>
            </div>
            <div class="col-lg-3 rrss">
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
  //el contador s'inicialitza en valor 0 i se va incrementant el numero cada cop que l'usuari afegeix un producte al carrito
  var contadorCarrito = 0;
  //aquesta funció el que fa es que cada cop que l'usuari li doni al botó doncs el contador del carrito sumi i es mostri el producte afegit al carrito
  function agregarAlCarrito(idProducto) {
      contadorCarrito++;
      document.getElementById("contadorCarrito").textContent = contadorCarrito;
      $.ajax({
        url: './../functions/agregar_al_carrito.php',
        type: 'POST',
        data: { id: idProducto },
        success: function(response) {
        }
      });
  }
</script>
<script>
//aquesta funció el que fa es que si el buscador no li pasem ningun parametre doncs que es quedi en aquesta pàgina sino que mostri el resultat de la busqueda feta 
function validar() {
    var searchInput = document.getElementById('searchInput').value;
    if (searchInput.trim() === "") {
        return false;
    }
    return true;
    
}
</script>
</body>
</html>
