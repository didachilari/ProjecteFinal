<?php
// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos
    $servername = "localhost";
    $username = "root";
      $password = "";


    $database = "couture";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Comprobar la conexión
    if ($conn->connect_error) {
        die("Connexió fallida: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $nom = $_POST["nom"];
    $cognoms = $_POST["cognoms"];
    $telf = $_POST["telf"];
    $data_naixament = $_POST["data_naixament"];
    $correu = $_POST["correu"];
    $dni = $_POST["dni"];
    $nom_usuari = $_POST["nom_usuari"];
    $contrasenya = $_POST["contrasenya"];

    // Verificar si todos los campos están llenos
    if (!empty($nom) && !empty($cognoms) && !empty($telf) && !empty($data_naixament) && !empty($correu) && !empty($dni) && !empty($nom_usuari) && !empty($contrasenya)) {
        // Preparar la consulta SQL para insertar los datos en la base de datos
        $sql = "INSERT INTO usuario (nom, cognoms, telf, data_naixament, correu, dni, nom_usuari, contrasenya) 
                VALUES ('$nom', '$cognoms', '$telf', '$data_naixament', '$correu', '$dni', '$nom_usuari', '$contrasenya')";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            // Después de crear, ir a login.php para iniciar sesión
            header("Location: ./login.php");
            exit(); 
        } else {
            // Si hay algún error al insertar en la base de datos
            $mensaje = "No s'ha creat l'usuari!";
            echo '<script>alert("' . $mensaje . '");</script>';
        }
    } 

    // Cerrar la conexión
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="cognoms" class="form-label">Cognoms:</label>
                <input type="text" class="form-control" id="cognoms" name="cognoms" required>
            </div>
            <div class="mb-3">
                <label for="telf" class="form-label">Telf:</label>
                <input type="tel" class="form-control" id="telf" name="telf" required>
            </div>
            <div class="mb-3">
                <label for="data_naixament" class="form-label">Data Naixament:</label>
                <input type="date" class="form-control" id="data_naixament" name="data_naixament" required>
            </div>
            <div class="mb-3">
                <label for="correu" class="form-label">Correu:</label>
                <input type="email" class="form-control" id="correu" name="correu" required>
            </div>
            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="text" class="form-control" id="dni" name="dni" required>
            </div>
            <div class="mb-3">
                <label for="nom_usuari" class="form-label">Nom usuari:</label>
                <input type="text" class="form-control" id="nom_usuari" name="nom_usuari" required>
            </div>
            <div class="mb-3">
                <label for="contrasenya" class="form-label">Contrasenya:</label>
                <input type="password" class="form-control" id="contrasenya" name="contrasenya" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
            <a href="./login.php" class="btn btn-secondary">Tornar</a>
        </form>
    </div>
</body>
</html>