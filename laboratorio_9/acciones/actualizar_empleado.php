<?php
// Incluir el archivo de conexión
require_once("conexion.php");

// Inicializar una respuesta vacía
$response = ["status" => "error", "message" => "Ocurrió un error inesperado."];

try {
    // Verificar si se han enviado los datos por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitizar los datos recibidos
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
        $rol = htmlspecialchars($_POST['rol'], ENT_QUOTES, 'UTF-8');

        // Validar que todos los campos requeridos tengan valores
        if (empty($correo) || empty($nombre) || empty($rol)) {
            $response = ["status" => "error", "message" => "Todos los campos son obligatorios."];
        }

        // Verificación del correo: debe contener un '@'
        elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $response = ["status" => "error", "message" => "El formato de correo no es válido."];
        }

        // Verificación del nombre: mínimo 3 letras
        elseif (strlen($nombre) < 3) {
            $response = ["status" => "error", "message" => "El nombre debe tener al menos 3 caracteres."];
        }

        // Verificación del nombre: solo letras y espacios permitidos
        elseif (!preg_match("/^[a-zA-Z\s]+$/", $nombre)) {
            $response = ["status" => "error", "message" => "El nombre solo debe contener letras."];
        } else {
            // Preparar la consulta SQL para actualizar los datos del empleado
            $stmt = $con->prepare("UPDATE usuarios SET nombre = ?, rol = ? WHERE correo = ?");
            $stmt->bind_param("sss", $nombre, $rol, $correo);

            // Ejecutar la consulta y verificar si fue exitosa
            if ($stmt->execute()) {
                // Enviar una respuesta JSON de éxito
                $response = ['status' => 'success', 'message' => 'El empleado ha sido actualizado correctamente.'];
            } else {
                $response = ["status" => "error", "message" => "Error al actualizar el empleado: " . $stmt->error];
            }

            // Cerrar la sentencia preparada
            $stmt->close();
        }
    }
} catch (Exception $e) {
    // Enviar un mensaje de error en formato JSON
    $response = ['status' => 'error', 'message' => $e->getMessage()];
} finally {
    // Cerrar la conexión a la base de datos
    $con->close();
    // Devolver la respuesta como JSON
    echo json_encode($response);
}
