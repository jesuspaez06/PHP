<?php
require_once 'conexion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (isset($_POST['correo'])) {
    $correo = $_POST['correo'];

    // Prepara la consulta SQL para eliminar al empleado con el correo proporcionado
    $stmt = $con->prepare("DELETE FROM usuarios WHERE correo = ?");
    
    if ($stmt === false) {
        // Error al preparar la declaración
        echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta.']);
        exit;
    }

    // Vincular parámetros
    $stmt->bind_param('s', $correo);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Consulta exitosa, empleado eliminado
        echo json_encode(['status' => 'success']);
    } else {
        // Error al ejecutar la consulta
        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el empleado.']);
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    // No se proporcionó el correo del empleado
    echo json_encode(['status' => 'error', 'message' => 'Correo del empleado no proporcionado.']);
}

// Cerrar la conexión
$con->close();
?>
