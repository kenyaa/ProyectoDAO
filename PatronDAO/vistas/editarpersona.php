<?php
// Manejando variables de sesion
session_start();
// Evaluando si tenemos sesion activa
if (isset($_SESSION["activo"])) {
    // Incluyendo cabecera y barra de navegacion del sitio
    require_once("template/header.php");
    require_once("template/navbar.php");
?>
<body>
    <div class="container">
        <form action="../controladores/controlador.php" method="post">
            <div class="form-row" style="padding-top: 1rem;">
                <div class="form-group col-md-6">
                    <label for="inputNombre">Nombre</label>
                    <input type="text" class="form-control" id="inputNombre" name="nombre" placeholder="Ingrese nombre" required autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputApellido">Apellido</label>
                    <input type="text" class="form-control" id="inputApellido" name="apellido" placeholder="Ingrese apellido" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button><br>
        </form>
    </div>
    <?php 
    // Incluyendo pie de pagina
    require_once("template/footer.php");
    ?>
</body>
</html>
<?php
} else {
    // En caso de no tener sesion activa, nos envia al login
    header("Location:../index.php");
    exit;
}
?>