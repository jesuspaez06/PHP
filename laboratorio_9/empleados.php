<?php
include 'acciones/conexion.php';

// Número de registros por página
$registrosPorPagina = 12;

// Página actual, por defecto es 1
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcular el índice de inicio
$inicio = ($paginaActual - 1) * $registrosPorPagina;

// Consultar el total de registros
$totalRegistrosResult = mysqli_query($con, "SELECT COUNT(*) as total FROM usuarios");
$totalRegistrosArray = mysqli_fetch_assoc($totalRegistrosResult);
$totalRegistros = $totalRegistrosArray['total'];

// Consultar los datos de la base de datos con límite y desplazamiento
$query = "SELECT correo, nombre, contrasena, rol FROM usuarios LIMIT $inicio, $registrosPorPagina";
$result = mysqli_query($con, $query);

if (!$result) {
  die('Consulta fallida: ' . mysqli_error($con));
}
?>


<div class="m-5">
<button type="button" class="btn btn-success mb-2" onclick="cargarModalRegisterEmpleado()"><i class="fa-solid fa-person-circle-plus"></i></button>
<table class="table table-dark table-striped ">
  <thead>
    <tr>
      <th scope="col">Correo</th>
      <th scope="col">Nombre</th>
      <th scope="col">Rol</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($empleado = mysqli_fetch_assoc($result)) { ?>
      <tr id="empleado_<?php echo htmlspecialchars($empleado['correo']); ?>">
        <td><?php echo htmlspecialchars($empleado['correo']); ?></td>
        <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
        <td><?php echo htmlspecialchars($empleado['rol']); ?></td>
        <td>
          <button class="btn btn-warning" onclick="CargarEditarEmpleado('<?php echo htmlspecialchars($empleado['correo']); ?>')"><i class="fa-solid fa-pen-to-square"></i></button>
          <button class="btn btn-danger" onclick="eliminarEmpleado('<?php echo htmlspecialchars($empleado['correo']); ?>')"><i class="fa-solid fa-trash"></i></button>
        </td>
      </tr>
    <?php } ?>
  </tbody>

</table>


<!-- Enlaces de paginación -->
<?php
// Calcular el total de páginas
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Mostrar enlaces de paginación
for ($i = 1; $i <= $totalPaginas; $i++) {
  echo "<a href='?pagina=$i' class='btn btn-primary'>$i</a> ";
}
?>
</div>
<script src="js/editarcontrasena.js"></script>
<script src="js/confirmar_delete_empleado.js"></script>
<script src="js/editar.js"></script>
<script src="js/registrarEmpleado.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>