<div class="modal fade" id="registrarEmpleadoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 titulo_modal">Registrar Empleado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Correo</label>
                <form class="form-label" id="formularioRegistrarEmpleado" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <input class="form-control" type="email" name="correo" id="correo" />

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" autocomplete="new-password" minlength="5" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="confirmar_password" id="confirmar_password" class="form-control" autocomplete="new-password" minlength="5" required />
                    </div>
                    <div id="error-message" style="color: red;"></div>
                    <div class="mb-3">
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
                    <div id="resultado"></div>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary btn_add" onclick="registrarEmpleado(event)">
                            Registrar
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>