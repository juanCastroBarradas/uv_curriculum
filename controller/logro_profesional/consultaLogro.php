<?php
session_start();
require_once '../../model/LogroProfesional.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $logro = new LogroProfesional();
    $logro->setProfesionalKey($profesorKey);

    $logro->setCondicion("persona_fkey", $logro->getProfesionalKey(), IGUAL, NUMERO);
    $aLogro= $logro->consultaByIdProfesor();

    if(!empty($aLogro)){
        if(count($aLogro) > 0){
            $arrayResponse["msj"] = "Datos del profesor encontrados.";
            $arrayResponse["status"] = "success";
            $arrayResponse["data"] = $aLogro;
        }
    }else{
        $arrayResponse["msj"] = "No existe informacion que coincida con el ID proporcionado.";
        $arrayResponse["status"] = "error";
        $arrayResponse["data"] = [];
    }

    
}
header('Content-type: application/json');
echo json_encode($arrayResponse);