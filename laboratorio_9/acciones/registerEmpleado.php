<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Inicializar una respuesta vacía
$response = ["status" => "error", "message" => "Ocurrió un error inesperado."];

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanitizar los datos del formulario
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $nombre = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $contrasena = $_POST['password'];
    $confirmar_contrasena = $_POST['confirmar_password'];
    $rol = htmlspecialchars($_POST['rol'], ENT_QUOTES, 'UTF-8');

    // Validar los datos
    if (empty($correo) || empty($nombre) || empty($contrasena) || empty($confirmar_contrasena) || empty($rol)) {
        $response = ["status" => "error", "message" => "Todos los campos son obligatorios."];
    } elseif (strlen($contrasena) < 5) {
        $response = ["status" => "error", "message" => "La contraseña debe tener al menos 5 caracteres."];
    } elseif ($contrasena != $confirmar_contrasena) {
        $response = ["status" => "error", "message" => "Las contraseñas no coinciden."];
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $nombre)) {
        $response = ["status" => "error", "message" => "El nombre solo debe contener letras."];
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $response = ["status" => "error", "message" => "El formato de correo no es válido."];
    } else {
        // Verificar si el correo ya existe
        $stmt = $con->prepare("SELECT correo FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = ["status" => "error", "message" => "El correo electrónico ya está registrado."];
        } else {
            // Preparar la consulta SQL para insertar el nuevo usuario
            $stmt = $con->prepare("INSERT INTO usuarios (correo, nombre, contrasena, rol) VALUES (?, ?, ?, ?)");
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

            if ($stmt) {
                // Vincular parámetros y ejecutar la consulta
                $stmt->bind_param("ssss", $correo, $nombre, $hashed_password, $rol);

                if ($stmt->execute()) {
                    $response = ["status" => "success", "message" => "Empleado registrado exitosamente."];
                } else {
                    $response = ["status" => "error", "message" => "Error al ejecutar la consulta: " . $stmt->error];
                }

                // Cerrar la declaración
                $stmt->close();
            } else {
                $response = ["status" => "error", "message" => "Error al preparar la consulta: " . $con->error];
            }
        }

        // Cerrar la conexión
        $con->close();
    }
}

// Devolver la respuesta como JSON
echo json_encode($response);
?>
