<?php
class addin_model{
    private $db;
    private $personas;
    private $proyecto;
    private $validador;
 
    public function __construct(){
        $this->db=ConectarPV::conexion();
        $this->personas=array();
        $this->proyecto =array();
        $this->validador =array();
    }
    public function get_personas(){
        $consulta=$this->db->query("select * from pms;");
        while($filas=$consulta->fetch_assoc()){
            $this->personas[]=$filas;
        }
        return $this->personas;
    }
  
    public function insert_project($proyecto_data){
        try {

            $revisarProyecto ="select * from proyecto where idProyecto=".$proyecto_data[0].";";
            $validador = $this->db->query($revisarProyecto);
            
            if(mysqli_num_rows($validador)>0)
            {
                     echo "El proyecto ya existe";
            }
            else
                {
                    $insertProyect ="insert into proyecto (idProyecto,lineaproyecto, numeroProyecto, nombreProyecto,clienteProyecto,pmProyecto) 
                    values  ('". $proyecto_data[0]."','". $proyecto_data[1]."','". $proyecto_data[2]."','". $proyecto_data[3]."','". $proyecto_data[4]."','". $proyecto_data[5]."');";
                
                    if( $consulta= $this->db->query($insertProyect)===TRUE)
                    {
                    echo "Datos insertados exitosamente";   
                    }
                    else
                    {
                        echo "Datos no ingresados";
                    }
                }
        } 
        catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    
    }

    public function insertar_hito_operacional($proyect_data){
        try {
         
            $revisarProyecto ="select * from proyecto where idProyecto=".$proyect_data[7].";";
            $validador = $this->db->query($revisarProyecto);
            
            if(mysqli_num_rows($validador)<=0)
            {
               echo "El proyecto no existe";
            }
            else
                {
                    // Son 7 valores
                    $insertProyect ="insert into hitosoperacionales 
                    (idHitosOperacionales,estadoHitosOperacionales, nombreHitosOperacionales,
                    fechaInicialHitosOperacionales, fechaFinalHitosOperacionales,
                    previstaInicialHitosOperacionales, previstaFinalHitosOperacionales, idProjecto) 
                    values  (". $proyect_data[0].",". $proyect_data[1].",'".
                     $proyect_data[2]."','". $proyect_data[3]."','". $proyect_data[4]."','".
                     $proyect_data[5]."','". $proyect_data[6]."',". $proyect_data[7].");";
                
                    if( $consulta= $this->db->query($insertProyect)===TRUE)
                    {
                        echo "Datos insertados exitosamente";   
                    }
                    else
                    {
                        echo "Datos no ingresados";
                    }
               }
        } 
        catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    
    }
    public function insertar_hito_financiero($proyect_data){
        try {
         
            $revisarProyecto ="select * from proyecto where idProyecto=".$proyect_data[7].";";
            $validador = $this->db->query($revisarProyecto);
            
            if(mysqli_num_rows($validador)<=0)
            {
               echo "El proyecto no existe";
            }
            else
                {
                    // Son 7 valores
                    $insertProyect ="insert into hitosoperacionales 
                    (idHitosOperacionales,estadoHitosOperacionales, nombreHitosOperacionales,
                    fechaInicialHitosOperacionales, fechaFinalHitosOperacionales,
                    previstaInicialHitosOperacionales, previstaFinalHitosOperacionales, idProjecto) 
                    values  (". $proyect_data[0].",". $proyect_data[1].",'".
                     $proyect_data[2]."','". $proyect_data[3]."','". $proyect_data[4]."','".
                     $proyect_data[5]."','". $proyect_data[6]."',". $proyect_data[7."',".
                     $proyect_data[8]."',".  $proyect_data[8]."',". $proyect_data[9].");";
                
                    if( $consulta= $this->db->query($insertProyect)===TRUE)
                    {
                        echo "Datos insertados exitosamente";   
                    }
                    else
                    {
                        echo "Datos no ingresados";
                    }
               }
        } 
        catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    
    }
}


// $insertProyect ="insert into hitosoperacionales 
            //         (idHitosOperacionales, estadoHitosOperacionales, nombreHitosOperacionales,
            //         fechaInicialHitosOperacionales, fechaFinalHitosOperacionales,
            //         previstaInicialHitosOperacionales, previstaFinalHitosOperacionales, idProjecto) 
            //         values  (4,1,'pm01:231','2018-12-20','2018-12-21','2018-12-22','2018-12-23',1);";
            //  echo $proyect_data[7];
            
?>
