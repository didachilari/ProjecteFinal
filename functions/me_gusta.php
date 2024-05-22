<?php 
include './functions/db_connection.php';
session_start();

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function me_gusta() {
    global $conn;

    if (!isset($_SESSION['id_usuario'])) {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
        exit;
    }

    $id_usuario = $_SESSION['id_usuario'];
    $id_producte = $_POST['id_producte'];

    try {
        $stmt_check = $conn->prepare("SELECT * FROM me_gusta WHERE id_usuario = ? AND id_producte = ?");
        $stmt_check->bind_param("ii", $id_usuario, $id_producte);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $stmt_delete = $conn->prepare("DELETE FROM me_gusta WHERE id_usuario = ? AND id_producte = ?");
            $stmt_delete->bind_param("ii", $id_usuario, $id_producte);
            $stmt_delete->execute();
            $stmt_delete->close();

            echo json_encode(['status' => 'success', 'message' => 'Me gusta eliminado correctamente']);
        } else {
            $stmt_insert = $conn->prepare("INSERT INTO me_gusta (id_usuario, id_producte) VALUES (?, ?)");
            $stmt_insert->bind_param("ii", $id_usuario, $id_producte);
            $stmt_insert->execute();
            $stmt_insert->close();

            echo json_encode(['status' => 'success', 'message' => 'Me gusta agregado correctamente']);
        }

        $stmt_check->close();
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Se produjo un error: ' . $e->getMessage()]);
    }
}

me_gusta();
?>
