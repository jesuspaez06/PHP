<?php
require_once("conexion.php");

// Obtener el parámetro `correo` de la solicitud
$correo = isset($_GET['correo']) ? $_GET['correo'] : '';

// Validar que `correo` no esté vacío
if (empty($correo)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Correo es requerido']);
    exit;
}

// Consultar la base de datos para obtener los detalles del empleado
$sql = "SELECT correo, nombre, contrasena, rol FROM usuarios WHERE correo = ? LIMIT 1";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 's', $correo);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $empleado = mysqli_fetch_assoc($result);
    // Devolver los detalles del empleado como un objeto JSON
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($empleado);

} else {
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'Empleado no encontrado']);
}

mysqli_close($con);
exit;
?>
