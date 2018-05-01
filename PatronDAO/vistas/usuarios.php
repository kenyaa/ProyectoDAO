<?php
// Incluyendo DTO persona para poder ser manejada desde el foreach
require_once("../dto/Usuario.php");
// Indicando manejo de sesiones
session_start();
// Evaluando si existe sesion activa
if (isset($_SESSION["activo"])) {
    // Incluyendo cabecera y barra de navegacion del sitio
    require_once("template/header.php");
    require_once("template/navbar.php");
?>
<body>
    <div class="container text-center">
        <h3 style="padding: 1rem 0;">Listado de usuarios</h3>
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">User</th>
                    <th scope="col">Password</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Evaluando si existe variable de sesion con el arreglos de objetos personas
                    if (isset($_SESSION["usuarios"])) {
                        // Obteniendo listado de personas mediante variable de sesion
                        $usuarios = $_SESSION["usuarios"];
                        // Recorriendo cada DTO de personas para mostrarlos en la tabla
                        foreach ($usuarios as $registro) {
                    ?>
                    <tr>
                        <td><?=$registro->id; ?></td>
                        <td><?=$registro->usuario; ?></td>
                        <td><?=$registro->password; ?></td>
                        <td>
                            <a href="../controladores/controlador.php?usuarios=modificar&id=<?=$registro->id; ?>" class="btn btn-info btn-sm">Modificar</a>
                            <a href="../controladores/controlador.php?usuarios=eliminar&id=<?=$registro->id; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                    <?php }
                    }; ?>
            </tbody>
        </table>
        <a href="../controladores/controlador.php?usuarios=agregar" class="btn btn-primary">Agregar usuarios</a>
    </div>
    <?php
    // Incluyendo pie de pagina
    require_once("template/footer.php");
    ?>
</body>
</html>
<?php
} else {
    // En caso de no existir sesion activa, se redirecciona al login
    header("Location: ../index.php");
    exit;
}
?>