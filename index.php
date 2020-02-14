<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//incluir archivos utilitarios
require_once("controllers/mobile_controller.php");

//incluir el archivo principal Slim
include("Slim/Slim.php");
//registran la instancia de slim
\Slim\Slim::registerAutoloader();
//aplicacion 
$app = new \Slim\Slim();

//routing 
//accediendo VIA URL
$app->get(
    '/',function() use ($app){
    

    echo "Servicios Proyecto PlayBus.";
    }
)
->setParams(array($app));

//routing playbusUsuarios
//accediendo VIA URL
$app->options('/api/playbusUsuariosLista/', function ($request, $response, $args) {
    return $response;
});

$app->get
(
    '/api/playbusUsuariosLista/', function(){
        // No valida parametros de entrada
        $a= new mobile_controller();
        $resp = $a->listarTodosLosUsuarios();
        // Valida respuesta de la consulta
        if (count($resp) > 0){
            $codRespuesta = 1;
            $msgRespuesta = "Sistema tiene usuarios";
        }else{
            $codRespuesta = 0;
            $msgRespuesta = "Sistema no tiene usuarios";
        }
        // Salida Json
        $pJson = json_encode(array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta,"lista"=>array_values($resp)));
        echo $pJson;
        }
);

//routing playbusUsuarios
//accediendo VIA URL
// APIRest de Perfil
$app->options('/api/playbusPerfilLista/', function ($request, $response, $args) {
    return $response;
});

$app->get
(
    '/api/playbusPerfilLista/',function(){
        $al = new mobile_controller();
        $resp = $al->listarTodosLosPerfiles();
        if (count($resp) > 0){
            $codRespuesta = 1;
            $msgRespuesta="Sistema tiene perfiles";
        }else{
            $codRespuesta= 0;
            $msgRespuesta= "Sistema no tiene perfiles";
        }
        // Salida del Json Response(ApiRest)
        $pJson = json_encode(array("codRespuesta" =>$codRespuesta, "msgRespuesta"=>$msgRespuesta, "lista"=>array_values($resp)));
        echo $pJson;
    }

);

//routing playbusUsuarios
//accediendo VIA URL
// APIRest de Acceso

$app->options('/api/playbusAccesoLista/', function ($request, $response, $args) {
    return $response;
});

$app->get
(
    '/api/playbusAccesoLista/',function(){
        $al = new mobile_controller();
        $resp = $al->listarTodosLosAccesos();
        if (count($resp) > 0){
            $codRespuesta = 1;
            $msgRespuesta="Sistema tiene accesos";
        }else{
            $codRespuesta= 0;
            $msgRespuesta= "Sistema no tiene accesos";
        }
        // Salida del Json Response(ApiRest)
        $pJson = json_encode(array("codRespuesta" =>$codRespuesta, "msgRespuesta"=>$msgRespuesta, "lista"=>array_values($resp)));
        echo $pJson;
    }

);

//routing playbusEquipos
//accediendo VIA URL
// APIRest de Equipos

$app->options('/api/playbusEquipoLista/', function ($request, $response, $args) {
    return $response;
});

$app->get
(
    '/api/playbusEquipoLista/',function(){
        $al = new mobile_controller();
        $resp = $al->listarTodosLosEquipos();
        if (count($resp) > 0){
            $codRespuesta = 1;
            $msgRespuesta="Sistema tiene equipos";
        }else{
            $codRespuesta= 0;
            $msgRespuesta= "Sistema no tiene equipos";
        }
        // Salida del Json Response(ApiRest)
        $pJson = json_encode(array("codRespuesta" =>$codRespuesta, "msgRespuesta"=>$msgRespuesta, "lista"=>array_values($resp)));
        echo $pJson;
    }

);

//routing login
//accediendo VIA URL
$app->options('/api/login/', function ($request, $response, $args) {
    return $response;
});

$app->post
(
    '/api/login/', function() use ($app){
		
		$parameters = json_decode($app->request()->getBody(), TRUE);
		$usuario = $parameters['Usuario'];
		$clave = $parameters['Password'];
        //$usuario = $_POST['Usuario'];
        //$clave = $_POST['Password'];
		
        $a= new mobile_controller();  
        $name = $a->obtenerAcceso($usuario);
        
        if (count($name) > 0){

            $tmp = $name[0]["pws_acceso"];

            if($clave==$tmp){
                $codRespuesta = 0;
                $msgRespuesta = "OK";
                $nomUser = $name[0]["user_acceso"];
                $idUser = $name[0]["id_acceso"];
                $permiso = $name[0]["perfil_acceso"];
            }else{
                $codRespuesta = -2;
                $msgRespuesta = "Clave invalida";
                $nomUser = "Error";
                $idUser = "0";
                $permiso = "0";
            }

        }else{
            $codRespuesta = -1;
            $msgRespuesta = "Usuario no existe";
            $nomUser = "Error";
            $idUser = "0";
            $permiso = "0";
        }

        $userData = array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta, "nomUser"=>$nomUser, "idUser"=>$idUser, "permiso"=>$permiso);
        $usuarioJson = json_encode($userData, JSON_FORCE_OBJECT);
        echo $usuarioJson;
        }
);

//routing playbusAccesos
//accediendo VIA URL
// Controlado Insertar Accesos
$app->options('/api/playbusAccesos/', function ($request, $response, $args) {
    return $response;
});

$app->post
(
    '/api/playbusAccesos/', function() use ($app){
    
        $parameters = json_decode($app->request()->getBody(), TRUE);
        $user = $parameters['user'];
        $pws = $parameters['pws'];
        $perfil = $parameters['perfil'];
		$estado = $parameters['estado'];
        // Valida parametros de entrada
        if ($user != null &&  $pws != null &&  $perfil != null &&  $estado != null){
            $a= new mobile_controller();
            $d1 = $a->regAcceso($user,$pws,$perfil,$estado);
            // Valida respuesta del registro
            if ($d1 == '1'){
                $codRespuesta = $d1;
                $msgRespuesta = "Acceso Registrado OK";
            } elseif ($d1 == '0') {
                $codRespuesta = $d1;
                $msgRespuesta = "Acceso ya existe!";
            } else {
                $codRespuesta = -1;
                $msgRespuesta = "Error al registrar Acceso!";
            }
        }else{
            $codRespuesta = -2;
            $msgRespuesta = "Paramétros requeridos";
        }
        $dData = array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta);
        //$dJson = json_encode(array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta));
        $dJson = json_encode($dData, JSON_FORCE_OBJECT);
        echo $dJson;
        }
);

//routing playbusAccesosActualizar
//accediendo VIA URL
// Controlado Insertar Accesos
$app->options('/api/playbusAccesosActualizar/', function ($request, $response, $args) {
    return $response;
});

$app->post
(
    '/api/playbusAccesosActualizar/', function() use ($app){
    
        $parameters = json_decode($app->request()->getBody(), TRUE);
        $id = $parameters['id'];
        $user = $parameters['user'];
        $pws = $parameters['pws'];
        $perfil = $parameters['perfil'];
		$estado = $parameters['estado'];
        // Valida parametros de entrada
        if ($id != null && $user != null &&  $pws != null &&  $perfil != null &&  $estado != null){
            $a= new mobile_controller();
            $d1 = $a->udpAcceso($id,$user,$pws,$perfil,$estado);
            // Valida respuesta del registro
            if ($d1 == '1'){
                $codRespuesta = 0;
                $msgRespuesta = "Datos actualizado OK";
    
            }else{
                $codRespuesta = -1;
                $msgRespuesta = "No se logra actualizar";
            }
        }else{
            $codRespuesta = -2;
            $msgRespuesta = "Paramétros requeridos";
        }
        $dData = array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta);
        //$dJson = json_encode(array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta));
        $dJson = json_encode($dData, JSON_FORCE_OBJECT);
        echo $dJson;
        }
);

//routing playbusAccesosActualizar
//accediendo VIA URL
// Controlado Insertar Accesos
$app->options('/api/playbusAccesosEliminar/', function ($request, $response, $args) {
    return $response;
});

$app->post
(
    '/api/playbusAccesosEliminar/', function() use ($app){
    
        $parameters = json_decode($app->request()->getBody(), TRUE);
        $id = $parameters['id'];
        // Valida parametros de entrada
        if ($id != null){
            $a= new mobile_controller();
            $d1 = $a->delAcceso($id);
            // Valida respuesta del registro
            if ($d1 == '1'){
                $codRespuesta = 0;
                $msgRespuesta = "Datos eliminados OK";
    
            }else{
                $codRespuesta = -1;
                $msgRespuesta = "No se logra eliminar";
            }
        }else{
            $codRespuesta = -2;
            $msgRespuesta = "Paramétros requeridos";
        }
        $dData = array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta);
        //$dJson = json_encode(array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta));
        $dJson = json_encode($dData, JSON_FORCE_OBJECT);
        echo $dJson;
        }
);

//routing playbusEquipos
//accediendo VIA URL
$app->post
(
    '/api/playbusEquipos/', function(){
        $nombre = $_POST['nombre'];
        $codigo = $_POST['codigo'];
        $empresa = $_POST['empresa'];
		$flota = $_POST['flota'];
        // Valida parametros de entrada
        if ($nombre != null &&  $codigo != null &&  $empresa != null &&  $flota != null){
            $mc= new mobile_controller();
            $d1 = $mc->regEquipo($nombre,$codigo,$empresa,$flota);
            // Valida respuesta del registro
            if ($d1 == '1'){
                $codRespuesta = $d1;
                $msgRespuesta = "Equipo Registrado OK";
            } elseif ($d1 == '0') {
                $codRespuesta = $d1;
                $msgRespuesta = "Equipo ya existe";
            } else {
                $codRespuesta = -1;
                $msgRespuesta = "Error al registrar";
            }
        }else{
            $codRespuesta = -2;
            $msgRespuesta = "Parámetros requeridos";
        }

        $dData = array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta);
        $dJson = json_encode($dData, JSON_FORCE_OBJECT);
        echo $dJson;
        }
);

//routing playbusPerfiles
//accediendo VIA URL
$app->post
(
    '/api/playbusPerfiles/', function(){
        $nombre = $_POST['nombre'];
        // Valida parametros de entrada
        if ($nombre != null){
            $mc= new mobile_controller();
            $d1 = $mc->regPerfil($nombre);
            // Valida respuesta del registro
            if ($d1 == '1'){
                $codRespuesta = $d1;
                $msgRespuesta = "Perfil Registrado OK";
            } elseif ($d1 == '0') {
                $codRespuesta = $d1;
                $msgRespuesta = "Perfil ya existe";
            } else {
                $codRespuesta = -1;
                $msgRespuesta = "Error al registrar";
            }
        }else{
            $codRespuesta = -2;
            $msgRespuesta = "Parámetros requeridos";
        }

        $dData = array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta);
        $dJson = json_encode($dData, JSON_FORCE_OBJECT);
        echo $dJson;
        }
);

//routing playbusUsuarios
//accediendo VIA URL
$app->post
(
    '/api/playbusUsuarios/', function(){
        $rut = $_POST['rut'];
        $correo = $_POST['correo'];
        $bus = $_POST['bus'];
        // Valida parametros de entrada
        if ($rut != null &&  $correo != null){
            $a= new mobile_controller();
            $d1 = $a->regUsuario($rut,$correo,$bus);
            // Valida respuesta del registro
            if ($d1 == '1'){
                $codRespuesta = $d1;
                $msgRespuesta = "Usuario Registrado OK";
            } elseif ($d1 == '0') {
                $codRespuesta = $d1;
                $msgRespuesta = "Usuario ya existe";
            } else {
                $codRespuesta = -1;
                $msgRespuesta = "Error al registrar";
            }
        }else{
            $codRespuesta = -2;
            $msgRespuesta = "Parametros requeridos";
        }

        $dData = array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta);
        $dJson = json_encode($dData, JSON_FORCE_OBJECT);
        echo $dJson;
        }
);


//inicializamos la aplicacion(API)
$app->run();
?>