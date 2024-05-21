<?php
include "./db_connection.php";
$randomNumber = rand(1, 4);

// Assign the category based on the random number
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