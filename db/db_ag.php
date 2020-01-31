<?php

class Conectar{

    
    public static function conexion(){
        $conexion=new mysqli("localhost", "root", "", "calderon_control_playbus");
        //$conexion=new mysqli("localhost", "calderon_playbus", "playbus19", "calderon_control_playbus");
        $conexion->query("SET NAMES 'latin1'");
        return $conexion;
        echo "Conexión ok";
    }
}
?>