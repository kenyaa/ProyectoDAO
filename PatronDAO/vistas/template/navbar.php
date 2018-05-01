<!-- Barra de navegacion -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><?php echo $_SESSION["activo"]; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../controladores/controlador.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../controladores/controlador.php?usuarios=leer">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../controladores/controlador.php?persona=leer">Personas</a>
            </li>
        </ul>
        <ul class="navbar-nav mr-sm-2">
            <li class="nav-item">
                <a class="nav-link" href="../controladores/controlador.php?cerrar=true">Cerrar sesion</a>
            </li>
        </ul>
    </div>
</nav>