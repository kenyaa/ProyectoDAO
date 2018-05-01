<?php
// Agregando scripts necesarios
require_once("IDao.php");
require_once("../ds/DataSource.php");
require_once("../dto/Usuario.php");

// DAO para la tabla usuarios
class UsuarioDao implements IDao
{
    // Implementando metodo READ
    public function mostrar()
    {
        // Creando objeto del DataSource
        $conexion = new DataSource();
        // Conectando y comprobando conexion
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            // Variable que contendra objeto DTO
            $usuario = null;
            // Arreglo que contendra los objetos DTO
            $usuarios = array();
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL mostrarUsuario()";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Ejecutando sentencia
                $stmt->execute();
                // Vinculando variables a los campos de la tabla
                $stmt->bind_result($id, $us, $pass);
                // Evaluando existencia de registros e iterando cada uno
                while ($stmt->fetch()) {
                    // Objeto del tipo persona
                    $usuario = new Usuario();
                    // Asignando los registros al objeto
                    $usuario->id = $id;
                    $usuario->usuario = $us;
                    $usuario->password = $pass;
                    // Agregando el objeto al arreglo personas
                    array_push($usuarios, $usuario);
                }
                // Cerrando conexiones y liberando recursos
                $stmt->close();
                $conexion->desconectar();
                // Retornando arreglo con los empleados
                return $usuarios;
            } else {
                // Cerrando conexiones y liberando recursos
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }
        }
    }

    // Implementando metodo INSERT
    public function agregar($objeto)
    {
        // Creando objeto del DataSource
        $conexion = new DataSource();
        // Conectando y comprobando conexion
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            // Variable que contendra objeto DTO pasado como parametro
            $usuario = $objeto;
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL agregarUsuario(?, ?)";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Asignando variables para enviar como parametros al SP
                $stmt->bind_param("ss", $nombre, $password);
                // Obteniendo valores del objeto y asignandolos a las variables
                $nombre = $usuario->usuario;
                // Encriptando el password del usuario
                $password = password_hash($usuario->password, PASSWORD_DEFAULT);
                // Ejecutando sentencia
                $stmt->execute();
                // Obteniendo cantidad de registros afectados
                $registros = $stmt->affected_rows;
                // Cerrando conexiones y liberando recursos
                $stmt->close();
                $conexion->desconectar();
                // Retornando cantidad de registros afectados
                return $registros;
            } else {
                // Cerrando conexion y liberando recursos
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }
        }
    }

    // Implementando metodo UPDATE
    public function modificar($objeto)
    {
        $conexion = new DataSource();
        // Conectando y comprobando conexion
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            // Variable que contendra objeto DTO pasado como parametro
            $usuario = $objeto;
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL modificarUsuario(?,?,?)";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Asignando variables para enviar como parametros al SP
                $stmt->bind_param("iss",$id, $user, $passw);
                // Obteniendo valores del objeto y asignandolos a las variables
                $id=$usuario->id;
                $user = $usuario->usuario;
                $pass = $usuario->password;
                // Ejecutando sentencia
                $stmt->execute();
                // Obteniendo cantidad de registros afectados
                $registros = $stmt->affected_rows;
                // Cerrando conexiones y liberando recursos
                $stmt->close();
                $conexion->desconectar();
                // Retornando cantidad de registros afectados
                return $registros;
            } else {
                // Cerrando conexion y liberando recursos
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }
        }
    }

    // Implementando metodo DELETE
    public function eliminar($objeto)
    {
        // Creando objeto del DataSource
        $conexion = new DataSource();
        // Conectando y comprobando conexion
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            // Variable que contendra objeto DTO pasado como parametro
            $usuario = $objeto;
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL eliminarUsuario(?)";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Asignando variables para enviar como parametros al SP
                $stmt->bind_param("i", $id);
                // Obteniendo valores del objeto y asignandolos a las variables
                $id = $usuario->id;
                // Ejecutando sentencia
                $stmt->execute();
                // Obteniendo cantidad de registros afectados
                $registros = $stmt->affected_rows;
                // Cerrando conexiones y liberando recursos
                $stmt->close();
                $conexion->desconectar();
                // Retornando cantidad de registros afectados
                return $registros;
            } else {
                // Cerrando conexion y liberando recursos
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }
        }
    
    }

    public function verificarUsuario($usuario)
    {
        // Creando objeto del DataSource
        $conexion = new DataSource();
        // Conectando y comprobando conexion
        if (!$conexion->conectar()) {
            echo "La conexion fallo";
            exit;
        } else {
            // Variable que contendra la respuesta de la verificacion
            $valido = false;
            // Variable con llamada al procedimiento almacenado
            $sql = "CALL verificarUsuario(?)";
            // Preparando sentencia y evaluando preparacion
            if ($stmt = $conexion->preparar($sql)) {
                // Asignando variables para enviar como parametros al SP
                $stmt->bind_param("s", $nombre);
                // Obteniendo valores del objeto y asignandolos a las variables
                $nombre = $usuario->usuario;
                // Ejecutando sentencia
                $stmt->execute();
                // Vinculando variables a los campos de la tabla
                $stmt->bind_result($password);
                // Evaluando existencia de registros e iterando cada uno
                while ($stmt->fetch()) {
                    //  Evaluando si el password devuelto es igual al que contiene el DTO
                    if (password_verify($usuario->password,$password)) {
                        $valido = true;
                    }
                }
                // Cerrando conexiones y liberando recursos
                $stmt->close();
                $conexion->desconectar();
                // Retornando arreglo con los empleados
                return $valido;
            } else {
                // Cerrando conexiones y liberando recursos
                $conexion->desconectar();
                echo "Ocurrio un error al llamar al PS";
                exit;
            }
        }
    }
}
