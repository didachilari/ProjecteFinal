<?php
//iniciarem la sessió
session_start();

//verificarem si l'usuari a iniciat sessió
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

//obtindrem l'ID de l'usuari que ha iniciat sessió
$id_usuario = $_SESSION['id_usuario'];

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

//obtindrem els productes de l'usuari
$sql = "SELECT p.id_producte, p.nom, p.preu, p.foto, m.nom AS nombre_marca, p.categorias 
        FROM producte p 
        INNER JOIN marcas m ON p.id_marcas = m.id_marcas 
        WHERE p.id_usuari = $id_usuario";
$result = $conn->query($sql);

//el que farem sera un array per emmagatzemar els productes de l'usuari
$productos_usuario = [];

//obtindrem els resultats de la consulta dels productes
while ($row = $result->fetch_assoc()) {
    $productos_usuario[] = $row;
}

//farem una funció per eliminar un producte 
if (isset($_POST['eliminar_producto'])) {
    $id_producto = $_POST['eliminar_producto'];

    $sql = "DELETE FROM producte WHERE id_producte = $id_producto AND id_usuari = $id_usuario";
    $conn->query($sql);

    header("Location: pagina-usuario.php");
    exit();
}

//tancarem la connexió
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">CoutureApp</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
                        </form>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="pagina-usuario.php"><i class="bi bi-person-circle"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./../index.php"><i class="bi bi-cart"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php"><i class="bi bi-house-door"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="container mt-5">
        <h1>Mis Productos</h1>
        <?php if (count($productos_usuario) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Precio</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos_usuario as $producto): ?>
                        <tr>
                            <td><?php echo $producto['nom']; ?></td>
                            <td><?php echo $producto['preu']; ?></td>
                            <td><?php echo $producto['nombre_marca']; ?></td>
                            <td><?php echo $producto['categorias']; ?></td>
                            <td>
                                <?php if(isset($producto['foto']) && !empty($producto['foto'])): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['foto']); ?>" alt="" style="max-width: 500px; max-height: 500px;">
                                <?php else: ?>
                                    <p>No disponible</p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="eliminar_producto" value="<?php echo $producto['id_producte']; ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                                <a href="editar-productes.php?id=<?php echo $producto['id_producte']; ?>" class="btn btn-primary">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tienes ningún producto aún.</p>
        <?php endif; ?>
    </div>
</body>
</html>
