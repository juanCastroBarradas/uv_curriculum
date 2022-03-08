<?php
session_start();
require_once '../../model/GestionAcademica.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion a caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $gestion = new GestionAcademica();
    $gestion->setProfesionalKey($profesorKey);

    $gestion->setCondicion("persona_fkey", $gestion->getProfesionalKey(), IGUAL, NUMERO);
    $agestion = $gestion->consultaByIdProfesor();

    if(!empty($agestion)){
        if(count($agestion) > 0){
            $arrayResponse["msj"] = "Datos del profesor encontrados.";
            $arrayResponse["status"] = "success";
            $arrayResponse["data"] = $agestion;
        }
    }else{
        $arrayResponse["msj"] = "No existe informacion que coincida con el ID proporcionado.";
        $arrayResponse["status"] = "error";
        $arrayResponse["data"] = [];
    }


}
header('Content-type: application/json');
echo json_encode($arrayResponse);