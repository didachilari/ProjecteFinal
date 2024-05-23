<?php
//aqui el que farem que amb aquesta funció es mostrar els productes de les categories que hi ha amb un numero random cada cop que la pàgina s'ecarrega
include "db_connection.php";
$randomNumber = rand(1, 4);

$category = "";
switch ($randomNumber) {
    case 1:
        $category = "Calzado";
        break;
    case 2:
        $category = "Camisa";
        break;
    case 3:
        $category = "Camiseta";
        break;
    case 4:
        $category = "Abrigo";
        break;
}
?>