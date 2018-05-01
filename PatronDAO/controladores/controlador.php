<?php
// Indicando manejo de sesiones
session_start();

# Verificaciones para determinar acciones a tomar

// Evaluando si tenemos sesion activa
if (isset($_SESSION["activo"])) {
    // Evaluando si deseamos cerrar sesion
    if (isset($_GET["cerrar"]) && $_GET["cerrar"] == "true") {
        // Cerrando sesion
        cerrarSesion();
        // Evaluando si estamos agregando nueva persona
    } else if (isset($_POST["nombre"]) && isset($_POST["apellido"])) {
        // En el caso de agregar una nueva persona
        agregarPersona();
    }
    else if (isset($_POST["user"]) && isset($_POST["password"])) {
        // En el caso de agregar una nueva persona
        agregarUsuario();
        // Evaluando si queremos agregar una nueva persona
    }  else if(isset($_GET["persona"]) && $_GET["persona"] == "agregar") {
        // En el caso de querer agregar una nueva persona
        agregarEditarPersona();
        // Evaluando si queremos mostrar el listado de personas
    }else if(isset($_GET["usuarios"]) && $_GET["usuarios"] == "agregar") {
        // En el caso de querer agregar una nueva persona
        agregarEditarUsuario();
        // Evaluando si queremos mostrar el listado de personas
    }  else if(isset($_GET["persona"]) && $_GET["persona"] == "leer") {
        // En el caso de mostrar personas
        mostrarPersonas();
    } else if(isset($_GET["usuarios"]) && $_GET["usuarios"] == "leer") {
        // En el caso de mostrar usuarios
        mostrarUsuarios();
        // Evaluando si queremos eliminar persona
    } else if(isset($_GET["persona"]) && $_GET["persona"] == "modificar" && isset($_GET["id"]) && $_GET["id"] > 0) {
        // En el caso de modificar una persona
        agregarEditarPersona();
    } else if(isset($_GET["usuarios"]) && $_GET["usuarios"] == "modificar" && isset($_GET["id"]) && $_GET["id"] > 0) {
        // En el caso de modificar una persona
        agregarEditarUsuario();
    } 
     else if(isset($_GET["persona"]) && $_GET["persona"] == "eliminar" && isset($_GET["id"]) && $_GET["id"] > 0) {
        // En el caso de eliminar una persona
        eliminarPersona();
    }else if(isset($_GET["usuarios"]) && $_GET["usuarios"] == "eliminar" && isset($_GET["id"]) && $_GET["id"] > 0) {
        // En el caso de eliminar una persona
        eliminarUsuario();
    } else {
        // En el caso de opcion invalida
        mostrarPrincipal();
    }
    // Evaluando si estamos viniendo desde el login
} else if (isset($_POST["usuario"]) && isset($_POST["password"])) {
    // En el caso de ingresar al sistema
    ingresar();
    // En caso que no existan datos por get o post
} else {
    // Enviando al usuario el login
    index();
}

# Metodos que permiten redirigir a diferentes vistas y realizar acciones

// Metodo que redirige al login
function index()
{
    header("Location:../index.php");
    exit;
}

// Metodo que verifica credenciales y permite acceso al sistema
function ingresar()
{
    // Haciendo uso del DTO y DAO para comprobar credenciales del usuario
    require_once("../dao/UsuarioDao.php");
    $usuario = new Usuario();
    $usuario->usuario = $_POST["usuario"];
    $usuario->password = $_POST["password"];
    $usuarioDao = new UsuarioDao();
    if ($usuarioDao->verificarUsuario($usuario)) {
        $_SESSION["activo"] = $usuario->usuario;
        mostrarPrincipal();
    } else {
        index();
    }
}

// Metodo que redirige al dashboard
function mostrarPrincipal()
{
    header("Location: ../vistas/dashboard.php");
    exit;
}

// Metodo que cierra la sesion
function cerrarSesion()
{
    session_destroy();
    index();
}

// Metodo que redirige a la gestion de personas
function mostrarPersonas()
{
    // Agregando DAO de persona
    require_once("../dao/PersonaDao.php");
    $personaDao = new PersonaDao();
    // Guardando el listado de personas en una variable de sesion
    $_SESSION["personas"] = $personaDao->mostrar();
    header("Location: ../vistas/personas.php");
    exit;
}

// Metodo que redirige a la gestion de usuarios
function mostrarUsuarios()
{
    // Agregando DAO de usuarios
    require_once("../dao/UsuarioDao.php");
    $usuarioDao = new UsuarioDao();
    // Guardando el listado de personas en una variable de sesion
    $_SESSION["usuarios"] = $usuarioDao->mostrar();
    header("Location: ../vistas/usuarios.php");
    exit;
}


// Metodo que permite agregar persona
function agregarPersona()
{
    // Agregando DAO persona
    require_once("../dao/PersonaDao.php");
    $persona = new Persona();
    $persona->nombre = $_POST["nombre"];
    $persona->apellido = $_POST["apellido"];
    $personaDao = new PersonaDao();
    if ($personaDao->agregar($persona) > 0) {
        // En caso que se haya agregado correctamente la persona
        mostrarPersonas();
    } else {
        // En caso de falla al agregar la persona
        header("Location: ../vistas/editarpersona.php");
        exit;
    }
}

// Metodo que permite agregar usuarios
function agregarUsuario()
{
    // Agregando DAO persona
    require_once("../dao/UsuarioDao.php");
    $usuario = new Usuario();
    $usuario->usuario = $_POST["user"];
    $usuario->password = $_POST["password"];
    $usuarioDao = new UsuarioDao();
    if ($usuarioDao->agregar($usuario) > 0) {
        // En caso que se haya agregado correctamente la persona
        mostrarUsuarios();
    } else {
        // En caso de falla al agregar la persona
        header("Location: ../vistas/agregarusuario.php");
        exit;
    }
}

// Metodo que permite agregar persona
function modificarPersona()
{
    // Agregando DAO persona
    require_once("../dao/PersonaDao.php");
    $persona = new Persona();
    $persona->id = $_GET["id"];
    $persona->nombre = $_POST["nombre"];
    $persona->apellido = $_POST["apellido"];
    $personaDao = new PersonaDao();
    if ($personaDao->modificar($persona) > 0) {
        // En caso que se haya modificado correctamente la persona
        mostrarPersonas();
    } else {
        // En caso de falla al agregar la persona
        header("Location: ../vistas/editarpersona.php");
        exit;
    }
}

function modificarUsuario()
{
    // Agregando DAO persona
    require_once("../dao/UsuarioDao.php");
    $usuario = new Persona();
    $usuario->id = $_GET["id"];
    $usuario->usuario = $_POST["user"];
    $usuario->password = $_POST["password"];
    $usuarioDao = new UsuarioDao();
    if ($usuarioDao->modificar($usuario) > 0) {
        // En caso que se haya modificado correctamente la persona
        mostrarUsuarios();
    } else {
        // En caso de falla al agregar la persona
        header("Location: ../vistas/agregarusuario.php");
        exit;
    }
}

// Metodo que redirige a la agregacion/edicion de persona
function agregarEditarPersona()
{
    header("Location: ../vistas/editarpersona.php");
    exit;
}


// Metodo que redirige a la agregacion/edicion de usuario
function agregarEditarUsuario()
{
    header("Location: ../vistas/agregarusuario.php");
    exit;
}

// Metodo que permite eliminar persona
function eliminarPersona()
{
    // Agregando DAO persona
    require_once("../dao/PersonaDao.php");
    $persona = new Persona();
    $persona->id = $_GET["id"];
    $personaDao = new PersonaDao();
    $personaDao->eliminar($persona);
    mostrarPersonas();
}

// Metodo que permite eliminar usuario
function eliminarUsuario()
{
    // Agregando DAO persona
    require_once("../dao/UsuarioDao.php");
    $usuario = new Usuario();
    $usuario->id = $_GET["id"];
    $UsuarioDao = new UsuarioDao();
    $UsuarioDao->eliminar($usuario);
    mostrarUsuarios();
}