<?php
//incluir el archivo principal
include("Slim/Slim.php");
//registran la instancia de slim
\Slim\Slim::registerAutoloader();
//aplicacion 
$app = new \Slim\Slim();

//routing 
//accediendo VIA URL
$app->get(
    '/',function() use ($app){
    echo "Bienvenido al Sistema de Gestión de Proyectos de ABB.";
    }
)
->setParams(array($app));
//Login OO
$app->post
    (
    '/login/',function(){
        $uid = $_POST['uid'];
        //    echo "Bienvenido ". $uid. "<BR>";
        $pw = $_POST['pw'];
        //    echo "Tu clave es ". $pw;
        //Leemos el XML con la información de los usuarios
        $usuarios = simplexml_load_file("usuarios2.xml");
        //Cantidad de Usuarios en el XML para el FOR
        $total_usuarios = count($usuarios->usuario);
        $total_usuarios--;
        $x=0;
        for($x=0;$total_usuarios;$x++){
            $nombrer = $usuarios->usuario[$x]->nombre;
            $tipor = $usuarios->usuario[$x]->tipo;
            $uidr = $usuarios->usuario[$x]->uid;
            $pwr = $usuarios->usuario[$x]->pw;
            //echo "Bienvenido ". $uid . ", tu usuario es " . $uidr . " y tu clave es ". $pwr . "<BR>";
            if($uid==$uidr){
                if($pw==$pwr){
//                    $userData->uid = $uidr;
//                    $userData->nombre = $nombrer;
//                    $userData->tipo = $tipor;
                    $userData = array($uidr, $nombrer, $tipor);
                    $usuarioJson = json_encode($userData, JSON_FORCE_OBJECT);
                    echo $usuarioJson;
                    break;
                } else {
                    echo "Clave incorrecta";
                    break;
                }
            }
            if($x===$total_usuarios){
                echo "Usuario " . $uid . " no existe!";
                //echo $x . " - " . $total_usuarios;
                break;
            }
        }
        }
    );
//inicializamos la aplicacion(API)
$app->run();
?>