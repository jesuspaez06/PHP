// Cargar y mostrar el modal de registro de empleado
async function cargarModalRegisterEmpleado() {
    try {
        const existingModal = document.getElementById("registrarEmpleadoModal");
        if (existingModal) {
            const modal = bootstrap.Modal.getInstance(existingModal);
            if (modal) {
                modal.hide();
            }
            existingModal.remove(); // Eliminar la modal existente si ya estaba cargada
        }

        // Realizar una solicitud GET usando Fetch para obtener el contenido del modal
        const response = await fetch("modales/registerEmpleadoModal.php");

        if (!response.ok) {
            throw new Error("Error al cargar el modal de registro");
        }

        // Obtener el contenido de la modal
        const modalHTML = await response.text();

        // Crear un elemento div para almacenar el contenido de la modal
        const modalContainer = document.createElement("div");
        modalContainer.innerHTML = modalHTML;

        // Agregar la modal al documento actual
        document.body.appendChild(modalContainer);

        // Mostrar la modal
        const myModal = new bootstrap.Modal(modalContainer.querySelector(".modal"));
        myModal.show();
    } catch (error) {
        console.error(error);
    }
}

// Validar y enviar el formulario mediante AJAX usando delegación de eventos
async function registrarEmpleado(event) {
    event.preventDefault();

    // Recoger los datos del formulario
    const formData = new FormData(document.getElementById('formularioRegistrarEmpleado'));

    try {
        const response = await fetch('acciones/registerEmpleado.php', {
            method: 'POST',
            body: formData
        });

        // Procesar la respuesta como JSON
        const resultado = await response.json();

        if (resultado.status === 'success') {
            alert(resultado.message);
            location.reload();  // Recargar la página en caso de éxito
        } else {
            document.getElementById('resultado').innerHTML = resultado.message;
         
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert("Ocurrió un error al registrar al empleado.");
    }
}
