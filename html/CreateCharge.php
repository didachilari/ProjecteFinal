<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey("sk_test_51PEn8fF6jOXWWkOuhlkC1Vn8H0tqoo4C8Pdc3QkWIcggs9EzgHXKhX7iJnLT2Q4A2qRi5UFywcmlbgtzeunzYJmO00jjKT2SMj");

//iniciarem la variable $error
$error = '';

if (isset($_GET["total"])) {
    $precioTotal = intval($_GET["total"]); //obtindrem el total de la URL i el convertirem a numero enter

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $token = $_POST['stripeToken'];

        try {
            //crearem la compra dels productes amb Stripe
            $charge = \Stripe\Charge::create([
                "amount" => $precioTotal,
                "currency" => "eur", 
                "description" => "Pago en mi tienda",
                "source" => $token
            ]);

            //si la compra s'ha fet doncs que ens envï a index.php
            header('Location: ../index.php');
            exit();
        } catch (\Stripe\Exception\CardException $e) {
            //s'hi ha un error amb la targeta doncs mostrar a l'usuari l'error
            $error = $e->getError()->message;
        } catch (Exception $e) {
            //s'hi ha un error general doncs mostrar a l'usuari l'error
            $error = $e->getMessage();
        }
    }
} else {
    //s'hi ha un error amb l'envïu total doncs mostrar un missatge
    $error = "Error: No se recibió el total.";
}

//mostrar a l'usuari els errors que hi hagi
if (!empty($error)) {
    echo "Error: " . $error;
}
?>
