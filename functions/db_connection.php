<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "couture";
  $conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>