<?php
  //connexió a la bbdd
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $database = "couture";
  $conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>