<?php
class mobile_model{
    private $db;
    private $personas;
    private $alertas;
 
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->personas=array();
        $this->accesos=array();
        $this->accesosUser=array();
        $this->personasPms=array();
        $this->usuarios=array();
		$this->perfiles=array();
		$this->equipos=array();
        $this->proyectos=array();
        $this->hitoso=array();
        $this->hitosf=array();
        $this->detp=array();
        $this->kpiGlobal=array();
        $this->kpiProyecto=array();
        $this->hitosGlobal=array();
        $this->alertas=array();
        $this->vencidos=array();
        $this->porVender=array();
    }

    public function get_usuarios(){

        $sql = "select id_usuario, rut_usuario, correo_usuario, id_bus_usuario, fecha_reg_usuario from playbus_usuarios ";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->usuarios[]=$filas;
        }
        return $this->usuarios;
    }

    public function reg_usuario($rut,$correo,$bus){
        try {
            $insert ="insert into playbus_usuarios 
            (rut_usuario,correo_usuario,id_bus_usuario) 
            values  ('".$rut."','".$correo."','".$bus."');";
        
            if( $consulta= $this->db->query($insert)===TRUE)
            {
                // echo "Datos insertados exitosamente";   
                return '1';
            }
            else
            {
                // echo "Datos no ingresados";
                return '-1';
            }
        } 
        catch (Exception $e) {
            // echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            return '-1';
        }
    
    }
	
    // JF- 02-02-2020 Método CRUD GET para listar los Perfiles.
    public function get_perfil(){
        $sql = "select id_perfil, nom_perfil from playbus_perfiles";

        $consulta = $this->db->query($sql);
        while ($filas=$consulta->fetch_assoc()) {
            $this->perfiles[]=$filas;
        }

        return $this->perfiles;
    }
	
	// JF- 02-02-2020 Método CRUD GET para listar los Equipos.
    public function get_equipo(){
        $sql = "select id_equipo, nombre_equipo, codigo_equipo, empresa_equipo, flota_equipo from playbus_equipos";

        $consulta = $this->db->query($sql);
        while ($filas=$consulta->fetch_assoc()) {
            $this->equipos[]=$filas;
        }

        return $this->equipos;
    }
	
    // JF- 27-01-2020 Método CRUD GET para listar los Accesos.
    public function get_acceso(){
        $sql = "select id_acceso, user_acceso, pws_acceso, perfil_acceso, estado_acceso from playbus_acceso";

        $consulta = $this->db->query($sql);
        while ($filas=$consulta->fetch_assoc()) {
            $this->accesos[]=$filas;
        }

        return $this->accesos;
    }

    // Consulta acceso por usuario
    public function get_accesoByUser($usuario){
        $sql = "select id_acceso, user_acceso, pws_acceso, perfil_acceso, estado_acceso from playbus_acceso ";
        $sql = $sql . "where user_acceso = '".$usuario."' ";
        $consulta = $this->db->query($sql);
        while ($filas=$consulta->fetch_assoc()) {
            $this->accesosUser[]=$filas;
        }

        return $this->accesosUser;
    }
	
	// JF- 31-01-2020 Método CRUD POST para insertar los Accesos.
	public function reg_acceso($user,$pws,$perfil,$estado){
		try{
			$insert ="insert into playbus_acceso
			(user_acceso,pws_acceso,perfil_acceso,estado_acceso) 
			values ('".$user."','".$pws."','".$perfil."','".$estado."');";
			
			if( $consulta= $this->db->query($insert)===TRUE)
			{
				//echo "Datos insertados exitosamente";
				return '1';
			}
			else
			{
				// echo "Datos no insertados";
				return '-1';
			}
		}catch (Exception $e){
			// echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			return '-1';
		}
		
	}

    // JF- 02-01-2020 Método CRUD POST para insertar los Equipos.
	public function reg_equipo($nombre,$codigo,$empresa,$flota){
		try{
			$insert ="insert into playbus_equipos
			(nombre_equipo,codigo_equipo,empresa_equipo,flota_equipo) 
			values ('".$nombre."','".$codigo."','".$empresa."','".$flota."');";
			
			if( $consulta= $this->db->query($insert)===TRUE)
			{
				// echo "Datos insertados exitosamente";
				return '1';
			}
			else
			{
				// echo "Datos no insertados";
				return '-1';
			}
		}catch (Exception $e){
			// echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			return '-1';
		}
		
    }
    
    public function upd_equipo($id,$nombre,$codigo,$empresa,$flota){

        $sql = " UPDATE playbus_equipos ";
        $sql = $sql . " SET nombre_equipo = '".$nombre."' ";
        $sql = $sql . " ,codigo_equipo = '".$codigo."' ";
        $sql = $sql . " ,empresa_equipo = '".$empresa."' ";
        $sql = $sql . " ,flota_equipo = '".$flota."' ";
        $sql = $sql . " WHERE id_equipo = ".$id."; ";
        //echo $sql;
        if ($consulta= $this->db->query($sql)===TRUE) {
            return "1";
        } else {
            // echo "Error updating record: " . $conn->error;
            return "-1";
        }

    }

    public function del_equipo($id){

        $sql = " DELETE from playbus_equipos ";
        $sql = $sql . " WHERE id_equipo = ".$id."; ";
        //echo $sql;
        if ($consulta= $this->db->query($sql)===TRUE) {
            return "1";
        } else {
            // echo "Error deleting record: " . $conn->error;
            return "-1";
        }

    }
	
	// JF- 02-01-2020 Método CRUD POST para insertar los Perfiles.
	public function reg_perfil($nombre){
		try{
			$insert ="insert into playbus_perfiles
			(nom_perfil) 
			values ('".$nombre."');";
			
			if( $consulta= $this->db->query($insert)===TRUE)
			{
				// echo "Datos insertados exitósamente";
				return '1';
			}
			else
			{
				// echo "Datos no insertados";
				return '-1';
			}
		}catch (Exception $e){
			// echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			return '-1';
		}
		
    }
    
    public function udp_acceso($id,$user,$pws,$perfil,$estado){

        $sql = " UPDATE playbus_acceso ";
        $sql = $sql . " SET user_acceso = '".$user."' ";
        $sql = $sql . " ,pws_acceso = '".$pws."' ";
        $sql = $sql . " ,perfil_acceso = '".$perfil."' ";
        $sql = $sql . " ,estado_acceso = '".$estado."' ";
        $sql = $sql . " WHERE id_acceso = ".$id."; ";
        //echo $sql;
        if ($consulta= $this->db->query($sql)===TRUE) {
            return "1";
        } else {
            // echo "Error updating record: " . $conn->error;
            return "-1";
        }

    }

    public function del_acceso($id){

        $sql = " DELETE from playbus_acceso ";
        $sql = $sql . " WHERE id_acceso = ".$id."; ";
        //echo $sql;
        if ($consulta= $this->db->query($sql)===TRUE) {
            return "1";
        } else {
            // echo "Error deleting record: " . $conn->error;
            return "-1";
        }

    }

}

?>