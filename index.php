<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Allow-Headers: X-Requested-With");
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
$app->post
(
    '/api/login/', function(){
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
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

//routing login
//accediendo VIA URL
$app->put('/api/login/', function ($request, $response) {
    $input = $request->getParsedBody();
    $input[‘correo’] = $args[‘correo’];
    return $this->response->withJson($input);
});

//routing playbusAccesos
//accediendo VIA URL
// Controlado Insertar Accesos
$app->post
(
    '/api/playbusAccesos/', function(){
        $user = $_POST['user'];
        $pws = $_POST['pws'];
        $perfil = $_POST['perfil'];
		$estado = $_POST['estado'];
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