<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey("sk_test_51PEn8fF6jOXWWkOuhlkC1Vn8H0tqoo4C8Pdc3QkWIcggs9EzgHXKhX7iJnLT2Q4A2qRi5UFywcmlbgtzeunzYJmO00jjKT2SMj");

/* Verifica si se recibió el valor total */
if (!isset($_GET['total'])) {
    die("Error: Total no especificado.");
}

$total = (int)$_GET['total'];

$YOUR_DOMAIN = 'http://localhost:8080';

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Total del Carrito',
                ],
                'unit_amount' => $total,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/ProjecteFinal/ProjecteFinal/html/sucess.php',
    ]);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="finalizar-compra">
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
        <form class="d-flex" role="search" action="resultados_busqueda.php" method="GET" onsubmit="return validar()">
          <button class="btn" type="submit"><i class="bi bi-search"></i></button>
          <input class="form-control" type="search" placeholder="Buscar" aria-label="Search" name="search" id="searchInput">        </form>
      </div>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./camisa.php">Camisa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./camiseta.php">Camiseta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pantalon.php">Pantalon</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./chaquetas.php">Chaquetas</i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./calzado.php">Calzado</i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
    <div class="container">
        <div class="main mb-4">
            <h1>Finalizar Compra</h1>
            <button id="checkout-button" class="btn">Pagar con Stripe</button>
        </div>
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
              <a href="https://www.instagram.com"><i class="bi bi-instagram"></i></a>
              <a href="https://www.facebook.com"><i class="bi bi-facebook"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
    <script type="text/javascript">
        var stripe = Stripe('pk_test_51PEn8fF6jOXWWkOuAqgNaFW41ZqbUIu5EiSSpYj6oLdSrYJmGohr6ngrpVP83Hd4h9JP8nXV5Zu7sLFcmv0YEpf200a2AZx2SJ');
        var checkoutButton = document.getElementById('checkout-button');

        checkoutButton.addEventListener('click', function () {
            stripe.redirectToCheckout({
                sessionId: '<?= $checkout_session->id ?>'
            }).then(function (result) {
                if (result.error) {
                    alert(result.error.message);
                }
            });
        });
    </script>
</body>
</html>
