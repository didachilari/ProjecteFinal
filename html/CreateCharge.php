<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey("sk_test_51PEn8fF6jOXWWkOuhlkC1Vn8H0tqoo4C8Pdc3QkWIcggs9EzgHXKhX7iJnLT2Q4A2qRi5UFywcmlbgtzeunzYJmO00jjKT2SMj");

// Inicializar la variable $error
$error = '';

if (isset($_GET["total"])) {
    $precioTotal = intval($_GET["total"]); // Obtener el total de la URL y convertir a entero

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $token = $_POST['stripeToken'];

        try {
            // Crear el cargo en Stripe
            $charge = \Stripe\Charge::create([
                "amount" => $precioTotal,
                "currency" => "eur", // Establecer la moneda a euros
                "description" => "Pago en mi tienda",
                "source" => $token
            ]);

            // Si el cargo se realiza correctamente, redirigir a una página de éxito
            header('Location: ../index.php');
            exit();
        } catch (\Stripe\Exception\CardException $e) {
            // Si hay un error con la tarjeta, mostrar un mensaje de error al usuario
            $error = $e->getError()->message;
        } catch (Exception $e) {
            // Si hay un error general, mostrar un mensaje de error al usuario
            $error = $e->getMessage();
        }
    }
} else {
    // Si no se envió el total, mostrar un mensaje de error
    $error = "Error: No se recibió el total.";
}

// Si hay un error, mostrarlo al usuario
if (!empty($error)) {
    echo "Error: " . $error;
}
?>
