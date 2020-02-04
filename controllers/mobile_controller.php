<?php

require_once("db/db_ag.php");
require_once("models/mobile_model.php");
class mobile_controller
{
        // Listar todos los usuarios
        function listarTodosLosUsuarios(){
                $class = new mobile_model();
                $valor= $class->get_usuarios();
                return $valor;
        }
        // registrar usuario
        function regUsuario($rut,$correo,$bus){
                $class = new mobile_model();
                $valor= $class->reg_usuario($rut,$correo,$bus);
                return $valor;
        }
        // Listar todos los accesos
        function listarTodosLosAccesos(){
                $class = new mobile_model();
                $valor = $class->get_acceso();
                return $valor;
        }

        function obtenerAcceso($usuario){
                $class = new mobile_model();
                $valor = $class->get_accesoByUser($usuario);
                return $valor;
        }
	    // Listar todos los perfiles
        function listarTodosLosPerfiles(){
                $class = new mobile_model();
                $valor = $class->get_perfil();
                return $valor;
	    }
		// Listar todos los equipos
        function listarTodosLosEquipos(){
                $class = new mobile_model();
                $valor = $class->get_equipo();
                return $valor;
        }
	    // Registrar equipos de usuarios
		function regEquipo($nombre,$codigo,$empresa,$flota){
			$class = new mobile_model();
			$valor = $class->reg_equipo($nombre,$codigo,$empresa,$flota);
			return $valor;
		}
	    // Registrar perfiles de usuarios
		function regPerfil($nombre){
			$class = new mobile_model();
			$valor = $class->reg_perfil($nombre);
			return $valor;
		}
		// Registrar accesos de usuarios
		function regAcceso($user,$pws,$perfil,$estado){
			$class = new mobile_model();
			$valor = $class->reg_acceso($user,$pws,$perfil,$estado);
			return $valor;
		}

}


?>