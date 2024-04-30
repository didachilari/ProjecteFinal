<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "couture";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    header("Location: pagina-usuario.php");
    exit();
}

$id_producto = $_GET['id'];

$sql = "SELECT id_producte, nom, preu, foto, id_marcas FROM producte WHERE id_producte = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "El producto no existe.";
    exit();
}

$producto = $result->fetch_assoc();

$sql_marcas = "SELECT id_marcas, nom FROM marcas";
$result_marcas = $conn->query($sql_marcas);

if (!$result_marcas) {
    echo "Error al obtener las marcas: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
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
                            <button class="btn btn-outline-primary " type="submit"><i class="bi bi-search"></i> Buscar</button>
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
        <h1>Editar Producto</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $producto['nom'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" value="<?= $producto['preu'] ?>" min="0" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <select class="form-select" id="marca" name="marca" required>
                    <?php while ($marca = $result_marcas->fetch_assoc()): ?>
                        <option value="<?= $marca['id_marcas'] ?>" <?= ($producto['id_marcas'] == $marca['id_marcas']) ? 'selected' : '' ?>><?= $marca['nom'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
