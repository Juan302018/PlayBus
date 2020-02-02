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
// Controlador de Acceso
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
        $pJson = json_decode(array("codRespuesta" =>$codRespuesta, "msgRespuesta"=>$msgRespuesta, "lista"=>array_values($resp)));
        echo $pJson;
    }

);

//routing playbusUsuarios
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
            $d1 = $a->regUsuario($user,$pws,$perfil,$estado);
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

        $dJson = json_encode(array("codRespuesta"=>$codRespuesta, "msgRespuesta"=>$msgRespuesta));
        //$dJson = json_encode($dData, JSON_FORCE_OBJECT);
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