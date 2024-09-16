async function editarEmpleadoContraseña(correoEmpleado) {
    try {
        console.log(correoEmpleado);
        // Ocultar la modal si está abierta
        const existingModal1 = document.getElementById("editarEmpleadoModal");
        if (existingModal1) {
            const modal1 = bootstrap.Modal.getInstance(existingModal1);
            if (modal1 && modal1._isShown) {
                modal1.hide();
            }
            setTimeout(() => {
                existingModal1.remove();
            }, 100);
        }

        const existingModal = document.getElementById("editarEmpleadoContraseñaModal");
        if (existingModal) {
            const modal = bootstrap.Modal.getInstance(existingModal);
            if (modal) {
                modal.hide();
            }
            existingModal.remove(); // Eliminar la modal existente
        }

        const response = await fetch("modales/editarcontraseña.php");
        if (!response.ok) {
            throw new Error(`Error al cargar la modal de editar el empleado. Estado: ${response.status} - ${response.statusText}`);
        }
        const modalHTML = await response.text();

        // Crear un elemento div para almacenar el contenido de la modal
        const modalContainer = document.createElement("div");
        modalContainer.innerHTML = modalHTML;

        // Agregar la modal al documento actual
        document.body.appendChild(modalContainer);

        // Mostrar la modal de cambio de contraseña
        const myModal = new bootstrap.Modal(modalContainer.querySelector("#editarEmpleadoContraseñaModal"));
        myModal.show();

        // Esperar a que el modal se muestre completamente antes de asignar el valor al input de correo
        modalContainer.querySelector("#editarEmpleadoContraseñaModal").addEventListener('shown.bs.modal', function () {
            // Insertar el correo del empleado en el input de correo
            document.querySelector("#correo").value = correoEmpleado || "";
        });

        // Event listener para cuando se cierre el segundo modal
        modalContainer.querySelector("#editarEmpleadoContraseñaModal").addEventListener('hidden.bs.modal', function () {
            // Volver a abrir el primer modal
            if (existingModal1) {
                document.body.appendChild(existingModal1); // Volver a añadir el primer modal al DOM
                const modal1 = new bootstrap.Modal(existingModal1);
                modal1.show();
            }
        });

    } catch (error) {
        console.error("Error al mostrar la modal de editar el empleado:", error);
    }
}


// Validar y enviar el formulario mediante AJAX usando delegación de eventos
async function editarContrasenaEmpleado(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del botón
    const formulario = document.getElementById('formularioCambioContrasena');

    // Aquí puedes hacer las validaciones personalizadas si es necesario
    if (formulario.checkValidity()) { 
        try {
            // Crea un objeto FormData con los datos del formulario
            const formData = new FormData(formulario);

            // Enviar los datos mediante fetch
            const response = await fetch('acciones/actualizar_contrasena.php', {
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
            console.error(error);
        }
    } else {
        // Si el formulario no es válido, mostrar los errores de validación
        formulario.reportValidity();
    }
};
