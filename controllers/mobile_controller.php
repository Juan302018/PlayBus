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
		// Registrar accesos de usuarios
		function regAcceso($user,$pws,$perfil,$estado){
			$class = new mobile_model();
			$valor = $class->reg_acceso($user,$pws,$perfil,$estado);
			return $valor;
		}

}

?>