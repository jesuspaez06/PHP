// Validar y enviar el formulario mediante AJAX usando delegación de eventos
async function iniciarSession(event) {
    event.preventDefault();

    // Recoger los datos del formulario
    const formData = new FormData(document.getElementById('formularioIniciarSession'));

    try {
        const response = await fetch('acciones/iniciarSession.php', {
            method: 'POST',
            body: formData
        });

        // Procesar la respuesta como JSON
        const resultado = await response.json();

        if (resultado.status === 'success') {
            alert(resultado.message);
            window.location.href = './index.php';  // Redirigir a 'index.php' en caso de éxito

        } else {
            document.getElementById('resultado').innerHTML = resultado.message;
         
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert("Ocurrió un error al iniciar session.");
    }
}
