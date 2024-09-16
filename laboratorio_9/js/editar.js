/**
 * Función para mostrar la modal de editar el empleado
 */
async function CargarEditarEmpleado(correoEmpleado) {
    try {
        // Ocultar la modal si está abierta
        const existingModal = document.getElementById("editarEmpleadoModal");
        if (existingModal) {
            const modal = bootstrap.Modal.getInstance(existingModal);
            if (modal) {
                modal.hide();
            }
            existingModal.remove(); // Eliminar la modal existente
        }

        const response = await fetch("modales/editar.php");
        if (!response.ok) {
            throw new Error(`Error al cargar la modal de editar el empleado. Estado: ${response.status} - ${response.statusText}`);
        }
        const modalHTML = await response.text();

        // Crear un elemento div para almacenar el contenido de la modal
        const modalContainer = document.createElement("div");
        modalContainer.innerHTML = modalHTML;

        // Agregar la modal al documento actual
        document.body.appendChild(modalContainer);

        // Mostrar la modal
        const myModal = new bootstrap.Modal(modalContainer.querySelector("#editarEmpleadoModal"));
        myModal.show();

        await cargarDatosEmpleadoEditar(correoEmpleado);

        // Vincular el botón para cambiar contraseña con la función correspondiente
        document.getElementById("cambiarContrasenaBtn").addEventListener("click", () => {
            editarEmpleadoContraseña(correoEmpleado);
        });

    } catch (error) {
        console.error("Error al mostrar la modal de editar el empleado:", error);
    }
}

/**
 * Función para buscar información del empleado seleccionado y cargarla en la modal
 */
async function cargarDatosEmpleadoEditar(correoEmpleado) {
    try {
        const response = await axios.get(`acciones/detallesEmpleado.php?correo=${encodeURIComponent(correoEmpleado)}`);
      
        if (response.status === 200 && response.data) {
            const { correo, nombre, rol } = response.data;

            document.querySelector("#correo").value = correo || "";
            document.querySelector("#nombre").value = nombre || "";
          
            seleccionarrol(rol);
        } else {
            console.error("Error al cargar el empleado a editar: Datos no encontrados");
        }
    } catch (error) {
        console.error("Hubo un problema al cargar los detalles del empleado", error);
        alert("Hubo un problema al cargar los detalles del empleado");
    }
}

/**
 * Función para seleccionar el rol del empleado de acuerdo al rol actual
 */
function seleccionarrol(rolEmpleado) {
    const selectrol = document.querySelector("#rol");
    selectrol.value = rolEmpleado || "";
}

// Validar y enviar el formulario mediante AJAX usando delegación de eventos
async function editarEmpleado(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del botón
    const formulario = document.getElementById('formularioEmpleadoEdit');

    // Aquí puedes hacer las validaciones personalizadas si es necesario
    if (formulario.checkValidity()) { 
        try {
            // Crea un objeto FormData con los datos del formulario
            const formData = new FormData(formulario);

            // Enviar los datos mediante fetch
            const response = await fetch('acciones/actualizar_empleado.php', {
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


