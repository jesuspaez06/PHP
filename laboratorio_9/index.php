<?PHP 
session_start();
if (!isset($_SESSION["correo"]) || $_SESSION["rol"] !== "admin"){
    header("location: login.html");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/6bfccbfc94.js" crossorigin="anonymous"></script>
<!-- Incluir Axios desde una CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <title>Empleados</title>
</head>

<nav class="navbar bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand">
    <?php
echo $_SESSION["nombre"]; 
?>

 <?php
echo $_SESSION["rol"];
 ?>
    </a>
    <div class="d-flex" role="search">
          <a class="btn btn-outline-danger" href="acciones/cerrarSession.php" >Cerrar Session</a>
    </div>
  </div>
</nav>



<body>
    <h1 class="text-center p-5">Empleados</h1>
    <?php
    include("empleados.php"); ?>
   

</body>
</html>