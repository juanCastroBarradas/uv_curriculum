<?php
session_start();
require_once '../../model/Persona.php';
require_once '../../core/constants.php';

if(isset($_SESSION["profesor"])){

    $profesor = $_SESSION["profesor"];
    $noProfesor = $profesor["identificador"];
    if(isset($noProfesor) && $noProfesor != ""){
        
        $persona = new Persona();
        $persona->setNoProfesor($noProfesor);
    
        //verificamos que no exita ningun registro anterior del profesor, validando el numero de trabajador
        $persona->setCondicion("noProfesor", $persona->getNoProfesor(), IGUAL, NUMERO);
        $aPersona = $persona->consultaByNoProfesor();
    
        if(!empty($aPersona)){
            if(count($aPersona) > 0){
                $arrayResponse["msj"] = "Datos del prefesor encontrados.";
                $arrayResponse["status"] = "success";
                $arrayResponse["data"] = $aPersona;
            }
        }else{
            $arrayResponse["msj"] = "No existe informacion que coincida con el ID proporcionado.";
            $arrayResponse["status"] = "error";
        }
    }
}else{
    $arrayResponse = array("msj" => "La sesion a caducado, no se pueden consultar los datos", "status" => "error", "data" => null);
}

header('Content-type: application/json');
echo json_encode($arrayResponse);
