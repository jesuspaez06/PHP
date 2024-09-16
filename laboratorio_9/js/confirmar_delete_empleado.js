async function cargarModalConfirmacion() {
  try {
    const existingModal = document.getElementById("eliminarEmpleado");
    if (existingModal) {
      const modal = bootstrap.Modal.getInstance(existingModal);
      if (modal) {
        modal.hide();
      }
      existingModal.remove(); // Eliminar la modal existente
    }

    // Realizar una solicitud GET usando Fetch para obtener el contenido de la modal
    const response = await fetch("modales/eliminarEmpleado.php");

    if (!response.ok) {
      throw new Error("Error al cargar la modal de confirmación");
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

/**
 * Función para eliminar un empleado desde la modal
 */
async function eliminarEmpleado(idEmpleado) {
  try {
    await cargarModalConfirmacion();

    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");

    confirmDeleteBtn.addEventListener("click", async () => {
        try {
        const response = await fetch('acciones/eliminar_empleado.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            'correo': idEmpleado
          })
        });

        const result = await response.json();

        // Si la eliminación es exitosa, recargar la página
        if (result.status === 'success') {
          location.reload();  // Recarga la página actual
        } else {
          console.error(result.message);
        }
      } catch (error) {
        console.error('Error al eliminar el empleado:', error);
      }
    });
  } catch (error) {
    console.error(error);
  }
}
