<?php
session_start();
require_once '../../model/Reconocimiento.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $reconocimiento = new Reconocimiento();
    $reconocimiento->setProfesionalKey($profesorKey);

    $reconocimiento->setCondicion("persona_fkey", $reconocimiento->getProfesionalKey(), IGUAL, NUMERO);
    $aReconocimiento= $reconocimiento->consultaByIdProfesor();

    if(!empty($aReconocimiento)){
        if(count($aReconocimiento) > 0){
            $arrayResponse["msj"] = "Datos del profesor encontrados.";
            $arrayResponse["status"] = "success";
            $arrayResponse["data"] = $aReconocimiento;
        }
    }else{
        $arrayResponse["msj"] = "No existe informacion que coincida con el ID proporcionado.";
        $arrayResponse["status"] = "error";
        $arrayResponse["data"] = [];
    }

    
}
header('Content-type: application/json');
echo json_encode($arrayResponse);