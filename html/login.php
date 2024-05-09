<?php
//iniciarem la sessió
session_start();

//connexió bbdd
$servername = "localhost";
$username = "root";
$password = "";
$database = "couture";

$conn = new mysqli($servername, $username, $password, $database);

//verificarem la connexió
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

//verificarem s'hi s'ha enviat el formulari
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['password'];

    //consultarem per verificar si l'usuari i contrasenya estan a la bbdd
    $sql = "SELECT * FROM usuario WHERE nom_usuari = '$usuario' AND contrasenya = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        //inici de sessió exitos
        $row = $result->fetch_assoc();
        $_SESSION['id_usuario'] = $row['id_usuari']; //guardarem l'ID de l'usuari en la sessió
        $_SESSION['usuario'] = $usuario; 
        header("Location: ./../index.php");
        exit(); 
    }
     else {
        //usuari o contrasenya incorrecta
        $mensaje = "Usuari o contrasenya incorrectes!";
        echo '<script>alert("' . $mensaje . '");</script>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="login">        
    <div class="container">
        <div class="inicisessio">

            <div class="logo">CoutureAPP</div>
            <form id="loginform" action="login.php" method="post"> 
                <input type="text" name="usuario" placeholder="Nombre usuario" required>
                
                <input type="password" placeholder="Contraseña" name="password" required>
                
                <button type="submit" title="IniciarSession" name="IniciarSession" class="boton-incisessio">Iniciar Sesión</button>
            </form>
            <div class="pie-form">
                <a href="./registre.php">Crear Cuenta</a>
            </div>
        </div>
    
    </div>
</body>
</html>

