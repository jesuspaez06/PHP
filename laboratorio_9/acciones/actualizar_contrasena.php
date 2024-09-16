<?php
// Incluir el archivo de conexión
require_once("conexion.php");

// Inicializar una respuesta vacía
$response = ["status" => "error", "message" => "Ocurrió un error inesperado."];

try {
    // Verificar si se han enviado los datos por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
        $nueva_contraseña = $_POST['password'];
        $confirmar_nueva_contraseña = $_POST['confirmar_password'];

        // Depuración
        error_log("Correo: $correo");
        error_log("Contraseña: $nueva_contraseña");
        error_log("Confirmar Contraseña: $confirmar_nueva_contraseña");

        // Validar que el correo y la nueva contraseña no estén vacíos
        if (empty($correo) || empty($nueva_contraseña) || empty($confirmar_nueva_contraseña)) {
            $response = ["status" => "error", "message" => "Por favor, completa todos los campos."];
        }

        // Verificar si las contraseñas coinciden
        elseif ($nueva_contraseña !== $confirmar_nueva_contraseña) {
            $response = ["status" => "error", "message" => "Las contraseñas no coinciden."];
        }

        // Verificar la longitud mínima de la contraseña
        elseif (strlen($nueva_contraseña) < 5) {
            $response = ["status" => "error", "message" => "La contraseña debe tener al menos 5 caracteres."];
        }

        // Verificar si la contraseña contiene al menos un carácter especial
        elseif (!preg_match('/[^a-zA-Z\d]/', $nueva_contraseña)) {
            $response = ["status" => "error", "message" => "La contraseña debe contener al menos un carácter especial."];
        }

        else {
            // Encriptar la nueva contraseña
            $nueva_contraseña_encriptada = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

            // Verificar si el correo existe en la base de datos antes de intentar actualizar
            $stmt = $con->prepare('SELECT correo FROM usuarios WHERE correo = ?');
            if ($stmt) {
                $stmt->bind_param('s', $correo);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    error_log("El correo $correo existe en la base de datos.");
                    $stmt->close(); // Cerrar el statement anterior

                    // Preparar la consulta SQL para actualizar la contraseña
                    $stmt = $con->prepare('UPDATE usuarios SET contrasena = ? WHERE correo = ?');
                    if ($stmt) {
                        $stmt->bind_param('ss', $nueva_contraseña_encriptada, $correo);

                        // Ejecutar la consulta y verificar si se actualizó la contraseña
                        if ($stmt->execute()) {
                            if ($stmt->affected_rows > 0) {
                                $response = ["status" => "success", "message" => "Contraseña actualizada correctamente."];
                                error_log("Nueva contraseña (encriptada): $nueva_contraseña_encriptada");
                            } else {
                                $response = ["status" => "error", "message" => "No se realizó ningún cambio en la contraseña."];
                                error_log("No se actualizó ninguna fila.");
                            }
                        } else {
                            error_log("Error al ejecutar la consulta: " . $stmt->error);
                            $response = ["status" => "error", "message" => "Hubo un problema al actualizar la contraseña. Inténtalo de nuevo más tarde."];
                        }
                    } else {
                        error_log("Error al preparar la consulta de actualización: " . $con->error);
                        $response = ["status" => "error", "message" => "Error al preparar la consulta."];
                    }
                } else {
                    error_log("El correo $correo no existe en la base de datos.");
                    $response = ["status" => "error", "message" => "El correo proporcionado no existe."];
                }
            } else {
                error_log("Error al preparar la consulta de verificación: " . $con->error);
                $response = ["status" => "error", "message" => "Error al verificar el correo."];
            }
        }
    }
} catch (Exception $e) {
    // Enviar un mensaje de error en formato JSON
    $response = ["status" => "error", "message" => $e->getMessage()];
} finally {
    // Cerrar la conexión a la base de datos
    $con->close();
    // Devolver la respuesta como JSON
    echo json_encode($response);
}
