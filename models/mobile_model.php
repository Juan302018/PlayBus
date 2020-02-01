<?php
class mobile_model{
    private $db;
    private $personas;
    private $alertas;
 
    public function __construct(){
        $this->db=Conectar::conexion();
        $this->personas=array();
        $this->accesos=array();
        $this->personasPms=array();
        $this->usuarios=array();
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

        $sql = "select id_usuario, rut_usuario, correo_usuario from playbus_usuarios ";

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
	
    // JF- 27-01-2020 Método CRUD GET para listar los Accesos.
    public function get_acceso(){
        $sql = "select user_acceso, pws_acceso, perfil_acceso, estado_acceso from playbus_acceso";

        $consulta = $this->db->query($sql);
        while ($filas=$consulta->fetch_assoc()) {
            $this->accesos[]=$filas;
        }

        return $this->accesos;
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

    public function get_personasPms(){

        $sql = "select nombrePms, usuarioPms, idPms from usuario where tipoPms = 1 ";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->personasPms[]=$filas;
        }
        return $this->personasPms;
    }

    public function get_top_vencidos(){

        $sql = "select h.idHitosOperacionales, ";
        $sql = $sql . "h.nombreHitosOperacionales, ";
        $sql = $sql . "h.fechaFinalHitosOperacionales, ";
        $sql = $sql . "h.idProjecto, ";
        $sql = $sql . "(select numeroProyecto from proyecto where idProyecto = h.idProjecto) numeroProyecto, ";
        $sql = $sql . "(select nombrePms from usuario where idPms = (select pmProyecto from proyecto where idProyecto = h.idProjecto)) nombrePms, ";
        $sql = $sql . "DATEDIFF(h.fechaFinalHitosOperacionales,CURDATE()) dias ";
        $sql = $sql . "from hitosoperacionales h where h.idHitosOperacionales = ";
        $sql = $sql . "( ";
        $sql = $sql . "select min(idHitosOperacionales) from hitosoperacionales ";
        $sql = $sql . "where porcentaje <> 100 ";
        $sql = $sql . "and fechaFinalHitosOperacionales < CURDATE() ";
        $sql = $sql . "and idProjecto = h.idProjecto ";
        $sql = $sql . "order by fechaFinalHitosOperacionales desc ";
        $sql = $sql . ") limit 5 ";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->vencidos[]=$filas;
        }
        return $this->vencidos;
    }

    public function get_top_por_vencer(){

        $sql = "select h.idHitosOperacionales, ";
        $sql = $sql . "h.nombreHitosOperacionales, ";
        $sql = $sql . "h.fechaFinalHitosOperacionales, ";
        $sql = $sql . "h.idProjecto, ";
        $sql = $sql . "(select numeroProyecto from proyecto where idProyecto = h.idProjecto) numeroProyecto, ";
        $sql = $sql . "(select nombrePms from usuario where idPms = (select pmProyecto from proyecto where idProyecto = h.idProjecto)) nombrePms, ";
        $sql = $sql . "DATEDIFF(h.fechaFinalHitosOperacionales,CURDATE()) dias ";
        $sql = $sql . "from hitosoperacionales h where h.idHitosOperacionales = ";
        $sql = $sql . "( ";
        $sql = $sql . "select min(idHitosOperacionales) from hitosoperacionales ";
        $sql = $sql . "where porcentaje <> 100 ";
        $sql = $sql . "and fechaFinalHitosOperacionales > CURDATE() ";
        $sql = $sql . "and idProjecto = h.idProjecto ";
        $sql = $sql . "order by fechaFinalHitosOperacionales desc ";
        $sql = $sql . ") limit 5 ";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->porVender[]=$filas;
        }
        return $this->porVender;
    } 

    public function get_alerta($usuario){

        //$date = date('d-m-Y');

        $sql = "select id_alertas,id_pm, cod_proyecto, tipo_hito, tipo_alerta, titulo_alerta, fecha_termino, fecha_alerta, ";
        $sql = $sql . "(SELECT p.lineaProyecto FROM proyecto p where p.idProyecto =  cod_proyecto) as lineaProyecto, ";
        $sql = $sql . "(SELECT p.numeroProyecto FROM proyecto p where p.idProyecto =  cod_proyecto) as numeroProyecto, ";
        $sql = $sql . "(SELECT p.nombreProyecto FROM proyecto p where p.idProyecto =  cod_proyecto) as nombreProyecto ";
        $sql = $sql . "from alertas ";
        $sql = $sql . "where id_pm = '".$usuario."' ";
        $sql = $sql . "and cod_estado = 1 ";
        $sql = $sql . "and fecha_alerta = CURDATE()";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->alertas[]=$filas;
        }
        return $this->alertas;
    }

    public function get_personas($usuario){

        $sql = "select idPms,nombrePms,usuarioPms,tipoPms,permisoPms,categoriaPms,contrasenaPms ";
        $sql = $sql . "from usuario ";
        $sql = $sql . "where usuarioPms = '".$usuario."' ";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->personas[]=$filas;
        }
        return $this->personas;
    }
    public function get_proyectos($idPms){

        $sql = "select idProyecto,nombreProyecto ";
        $sql = $sql . "from proyecto ";
        $sql = $sql . "where pmProyecto = ".$idPms." ";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->proyectos[]=array("idProyecto"=>$filas["idProyecto"], "nombreProyecto"=>$filas["nombreProyecto"]);
        }
        return $this->proyectos;
    }
    public function get_ho($idProyecto){

        $sql = "select idHitosOperacionales,estadoHitosOperacionales,nombreHitosOperacionales,fechaFinalHitosOperacionales,porcentaje ";
        $sql = $sql . "from hitosoperacionales ";
        $sql = $sql . "where idProjecto = ".$idProyecto." ";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->hitoso[]=$filas;
        }
        return $this->hitoso;
    }  
    public function get_hf($idProyecto){

        $sql = "select hitosfacturacion.idHitosFacturacion, hitosfacturacion.estadoHitosFacturacion, hitosfacturacion.nombreHitosFacturacion ";
        $sql = $sql . ",hitosfacturacion.fechaFinalHitosFacturacion, hitosfacturacion.montoHitosFacturacion, ";
        $sql = $sql . "hitosfacturacion.divisaHitosFacturacion, hitosfacturacion.porcentajeHitosFacturacion, divisa.nombreDivisa ";
        $sql = $sql . "from hitosfacturacion ";
        $sql = $sql . "INNER JOIN divisa on hitosfacturacion.divisaHitosFacturacion=divisa.idDivisa ";
        $sql = $sql . "where hitosfacturacion.idProject = ".$idProyecto." ";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->hitosf[]=$filas;
        }
        return $this->hitosf;
    }   
    public function get_detProyecto($idProyecto){

        $sql = "select idProyecto,lineaProyecto,numeroProyecto,estadoProyecto ";
        $sql = $sql . "from proyecto ";
        $sql = $sql . "where idProyecto = ".$idProyecto." ";

        $consulta=$this->db->query($sql);
        while($filas=$consulta->fetch_assoc()){
            $this->detp[]=$filas;
        }
        return $this->detp;
    }
    
    public function udp_estProyecto($idProyecto,$estPro){

        if ($estPro == 'SI'){
            $estPro = 1;
        }else{
            $estPro = 0;
        }

        $sql = " UPDATE proyecto ";
        $sql = $sql . " SET estadoProyecto = '".$estPro."' ";
        $sql = $sql . " WHERE idProyecto = ".$idProyecto."; ";
        //echo $sql;
        if ($consulta= $this->db->query($sql)===TRUE) {
            return "1";
        } else {
            echo "Error updating record: " . $conn->error;
            return "-1";
        }

    }

    public function udp_hitosO($idProyecto,$hitosOpe){

        $resp = "0";
        $parts = explode(';', $hitosOpe);

        foreach ($parts as $idx=>$part)
        {
            $chars = explode(',', $part);
            
            if ($chars[0] === ''){
                //echo "vacio";
            }else{
                $d1=$chars[0];
                $d2=$chars[1];
                $d3=$chars[2];
                $d3=str_replace("%","",$d3);
                //echo $d1."-".$d2."-".$d3;
                $sql = " UPDATE hitosoperacionales ";
                $sql = $sql . " SET fechaFinalHitosOperacionales = '".$d2."', ";
                $sql = $sql . " porcentaje = '".$d3."' ";
                $sql = $sql . " where nombreHitosOperacionales = '".$d1."' ";
                $sql = $sql . " and idProjecto =".$idProyecto;
                
                //echo $sql;
                if ($consulta= $this->db->query($sql)===TRUE) {
                    $resp = "1";
                } else {
                    $resp = "-1";
                } 
            }
        }
        return $resp;
    }

    public function udp_hitosF($idProyecto,$hitosFac){

        $resp = "0";
        $parts = explode(';', $hitosFac);

        foreach ($parts as $idx=>$part)
        {
            $chars = explode(',', $part);
            
            if ($chars[0] === ''){
                //echo "vacio";
            }else{
                $d1=$chars[0];
                $d2=$chars[1];
                $d3=$chars[2];
                $d3=str_replace("%","",$d3);
                //echo $d1."-".$d2."-".$d3;
                $sql = " UPDATE hitosfacturacion ";
                $sql = $sql . " SET fechaFinalHitosFacturacion = '".$d2."', ";
                $sql = $sql . " porcentajeHitosFacturacion = '".$d3."' ";
                $sql = $sql . " where nombreHitosFacturacion = '".$d1."' ";
                $sql = $sql . " and idProject =".$idProyecto;
                
                //echo $sql;
                if ($consulta= $this->db->query($sql)===TRUE) {
                    $resp = "1";
                } else {
                    $resp = "-1";
                } 
            }
        }
        return $resp;
    }

    public function get_kpi_global(){

        try {
            // execute the stored procedure
            $sql = 'CALL calcular_kpis_Global(@cod_result,@FE,@FP,@FD,@PF,@CS)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            //$stmt->closeCursor();

            // execute the second query to get customer's FE
            $row = $this->db->query("SELECT @cod_result, @FE,@FP,@FD,@PF,@CS");
            while($filas=$row->fetch_assoc()){
                $this->kpiGlobal[]=$filas;
            }

        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            $this->kpiGlobal[]= null;
        }
        return $this->kpiGlobal;

    }

    public function get_kpi_proyecto($idProyecto){

        try {
            // execute the stored procedure
            $sql = 'CALL calcular_kpis_Proyecto('.$idProyecto.',@cod_result,@OTT,@FE,@FP,@FD,@PF)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            //$stmt->closeCursor();

            // execute the second query to get customer's FE
            $row = $this->db->query("SELECT @cod_result,@OTT,@FE,@FP,@FD,@PF");
            while($filas=$row->fetch_assoc()){
                $this->kpiProyecto[]=$filas;
            }

        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            $this->kpiProyecto[]= null;
        }
        return $this->kpiProyecto;

    }

    public function get_datos_hitos_global(){

        try {
            // execute the stored procedure
            $sql = 'CALL Datos_Hitos_Global(@cod_result,@F1,@F2,@F3,@O1,@O2,@O3)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            //$stmt->closeCursor();
            // execute the second query to get customer's FE
            $row = $this->db->query("SELECT @cod_result,@F1,@F2,@F3,@O1,@O2,@O3");
            while($filas=$row->fetch_assoc()){
                $this->hitosGlobal[]=$filas;
            }

        }catch (Exception $e) {
            echo 'Excepción capturada get_datos_hitos_global: ',  $e->getMessage(), "\n";
            $this->hitosGlobal[]= null;
        }
        return $this->hitosGlobal;

    }
}

?>