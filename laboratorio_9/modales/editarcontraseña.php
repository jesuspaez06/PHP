<div class="modal fade" id="editarEmpleadoContraseñaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 titulo_modal">Actualizar Contraseña</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioCambioContrasena"  method="POST" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="correo" id="correo" value="<?php echo htmlspecialchars($empleado['correo']); ?>" />

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="new-password" minlength="5" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="confirmar_password" id="confirmar_password" class="form-control" autocomplete="new-password" minlength="5" required />
                    </div>

                    <div id="resultado"></div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn_add" onclick="editarContrasenaEmpleado(event)">
                            Actualizar contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>