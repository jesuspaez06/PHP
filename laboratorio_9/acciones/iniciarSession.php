<?php
session_start();
include 'conexion.php';  // Archivo con la conexión a la base de datos

// Inicializar una respuesta vacía
$response = ["status" => "error", "message" => "Ocurrió un error inesperado."];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $contrasena = $_POST['contrasena'];

    if (!empty($correo) && !empty($contrasena) && filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        // Preparar la consulta para evitar inyecciones SQL y obtener también nombre y rol
        $stmt = $con->prepare("SELECT contrasena, nombre, rol FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Vincular los resultados de la consulta
            $stmt->bind_result($contrasena_hash, $nombre, $rol);
            $stmt->fetch();

            if (password_verify($contrasena, $contrasena_hash)) {
                // Iniciar la sesión y almacenar los datos del usuario
                $_SESSION["correo"] = $correo;
                $_SESSION["nombre"] = $nombre;
                $_SESSION["rol"] = $rol;

                // Redirigir al usuario a la página principal
                $response = ["status" => "success", "message" => "Ha ingresado correctamente"];

            } else {
                $response = ["status" => "error", "message" => "Contraseña incorrecta."];
            }
        } else {
            $response = ["status" => "error", "message" => "El correo no existe."];
        }

        $stmt->close();
    } else {
        $response = ["status" => "error", "message" => "Por favor, rellene los campos correctamente."];
    }
}

// Devolver la respuesta como JSON (solo si no se redirige)

    echo json_encode($response);

?>
