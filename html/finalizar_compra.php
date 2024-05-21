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
        'success_url' => $YOUR_DOMAIN . '/success.html',
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
</head>
<body>
    <h1>Finalizar Compra</h1>
    <button id="checkout-button">Pagar con Stripe</button>

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
