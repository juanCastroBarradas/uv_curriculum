<?php
session_start();
require_once '../../model/FormacionAcademica.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $formacion = new FormacionAcademica();
    $formacion->setProfesionalKey($profesorKey);

    $formacion->setCondicion("persona_fkey", $formacion->getProfesionalKey(), IGUAL, NUMERO);
    $aFormacion = $formacion->consultaByIdProfesor();

    if(!empty($aFormacion)){
        if(count($aFormacion) > 0){
            $arrayResponse["msj"] = "Datos del profesor encontrados.";
            $arrayResponse["status"] = "success";
            $arrayResponse["data"] = $aFormacion;
        }
    }else{
        $arrayResponse["msj"] = "No existe informacion que coincida con el ID proporcionado.";
        $arrayResponse["status"] = "error";
    }

    
}
header('Content-type: application/json');
echo json_encode($arrayResponse);