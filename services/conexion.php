<?php

class Conexion
{
    function obtenerConexion()
    {
        $conexion = mysqli_connect("127.0.0.1","root","","prueba");
        if(!$conexion)
        {
            echo ("ERROR EN LA CONEXIÓN");
            exit;
        }
        return $conexion;
    }
}

?>