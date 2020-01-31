<?php

 require_once("db/bdpv.php");
 require_once("models/addin_model.php");     
class addin_controller
{
        function buscarPMs()
        {
                $class = new addin_model();
                $valor= $class->get_personas();        
                return $valor;
        }

        function insertarProyecto($proyecto_data)
        {
                $class = new addin_model();
                $class->insert_project($proyecto_data);
        }
        function validadorProyecto($idot)
        {
                $class = new addin_model();
                $class-> validate_project($idot);
        }
        function insertarHitoOp($project_data)
        {
                $class = new addin_model();
                $class-> insertar_hito_operacional($project_data);
        }
        function insertarHitoFi($project_data)
        {
                $class = new addin_model();
                $class-> insertar_hito_financiero($project_data);
        }
}
?>