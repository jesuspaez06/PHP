<div class="modal fade" id="editarEmpleadoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 titulo_modal">Actualizar Información Empleado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioEmpleadoEdit"  method="POST" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="correo" id="correo" value="<?php echo htmlspecialchars($empleado['correo']); ?>" />

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" />
                    </div>

                    <div class="mb-3">

                        <button id="cambiarContrasenaBtn" type="button" class="btn btn-primary">Cambiar contraseña</button>


                    </div>

                    <div class="mb-3">
                        <label class="form-label">Seleccione el rol</label>
                        <select name="rol" id="rol" class="form-select" required>
                            <option selected disabled value="">Selecciona el rol</option>
                            <?php
                            $rols = array(
                                "admin",
                                "mod",
                                "user"
                            );
                            foreach ($rols as $rol) {
                                echo "<option value='$rol'>$rol</option>";
                            }
                            ?>
                        </select>

                    </div>

                    <br><br>
                    <div id="resultado"></div>
                    <div class="d-grid gap-2">
                        <button type="submit" id="editarEmpleadoContraseña" class="btn btn-primary btn_add" onclick="editarEmpleado(event)">
                            Actualizar datos del empleado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/editar.js"></script>