<?php
//iniciarem la sessió
session_start();
include "./../functions/db_connection.php";

//verificarem si s'ha enviat el formulari
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['password'];

    //farem una consulta a la bbdd per verificar si l'usuari i contrasenya esta creada
    $sql = "SELECT * FROM usuario WHERE nom_usuari = '$usuario' AND contrasenya = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        //inici de sessió exitos
        $row = $result->fetch_assoc();
        $_SESSION['id_usuario'] = $row['id_usuari']; 
        $_SESSION['usuario'] = $usuario; 
        $_SESSION['admin'] = $row['admin'];

        //si l'usuari es admin doncs que vagi aquesta pàgina sino...
        if ($row['admin']) {
            header("Location: ./crear_marca.php");
        } else {
            //...aquesta pàgina
            header("Location: ./../index.php");
        }
        exit();
    } else {
        //inici de sessió incorrecte
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
