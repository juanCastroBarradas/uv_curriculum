<?php
session_start();
require_once '../../model/CapacitacionDocente.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $capacitacionDocente = new CapacitacionDocente();
    $capacitacionDocente->setProfesionalKey($profesorKey);

    $capacitacionDocente->setCondicion("persona_fkey", $capacitacionDocente->getProfesionalKey(), IGUAL, NUMERO);
    $aCapacitacionDocente = $capacitacionDocente->consultaByIdProfesor();

    if(!empty($aCapacitacionDocente)){
        if(count($aCapacitacionDocente) > 0){
            $arrayResponse["msj"] = "Datos del profesor encontrados.";
            $arrayResponse["status"] = "success";
            $arrayResponse["data"] = $aCapacitacionDocente;
        }
    }else{
        $arrayResponse["msj"] = "No existe informacion que coincida con el ID proporcionado.";
        $arrayResponse["status"] = "error";
        $arrayResponse["data"] = [];
    }


}
header('Content-type: application/json');
echo json_encode($arrayResponse);