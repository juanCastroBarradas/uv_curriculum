<?php
session_start();
require_once '../../model/ExperienciaProfesional.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion a caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $experiencia = new ExperienciaProfesional();
    $experiencia->setProfesionalKey($profesorKey);

    $experiencia->setCondicion("persona_fkey", $experiencia->getProfesionalKey(), IGUAL, NUMERO);
    $aexperiencia = $experiencia->consultaByIdProfesor();

    if(!empty($aexperiencia)){
        if(count($aexperiencia) > 0){
            $arrayResponse["msj"] = "Datos del profesor encontrados.";
            $arrayResponse["status"] = "success";
            $arrayResponse["data"] = $aexperiencia;
        }
    }else{
        $arrayResponse["msj"] = "No existe informacion que coincida con el ID proporcionado.";
        $arrayResponse["status"] = "error";
        $arrayResponse["data"] = [];
    }


}
header('Content-type: application/json');
echo json_encode($arrayResponse);