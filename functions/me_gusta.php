<?php
session_start();
include './db_connection.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_producte = $_POST['id_producte'];

if (!$id_producte) {
    echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado']);
    exit;
}

$conn = OpenCon();

// Comprobar si ya existe el registro
$sql_check = "SELECT * FROM me_gusta WHERE id_usuario = ? AND id_producte = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_usuario, $id_producte);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    // Si existe, eliminar el registro
    $sql_delete = "DELETE FROM me_gusta WHERE id_usuario = ? AND id_producte = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $id_usuario, $id_producte);
    if ($stmt_delete->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Me gusta eliminado']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el me gusta']);
    }
    $stmt_delete->close();
} else {
    // Si no existe, insertar el registro
    $sql_insert = "INSERT INTO me_gusta (id_usuario, id_producte) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $id_usuario, $id_producte);
    if ($stmt_insert->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Me gusta agregado']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al agregar el me gusta']);
    }
    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>
