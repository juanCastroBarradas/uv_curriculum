<?php
session_start();
require_once '../../model/Participacion.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion a caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $participacion = new Participacion();
    $participacion->setProfesionalKey($profesorKey);

    $participacion->setCondicion("persona_fkey", $participacion->getProfesionalKey(), IGUAL, NUMERO);
    $aparticipacion = $participacion->consultaByIdProfesor();

    if(!empty($aparticipacion)){
        if(count($aparticipacion) > 0){
            $arrayResponse["msj"] = "Datos del profesor encontrados.";
            $arrayResponse["status"] = "success";
            $arrayResponse["data"] = $aparticipacion;
        }
    }else{
        $arrayResponse["msj"] = "No existe informacion que coincida con el ID proporcionado.";
        $arrayResponse["status"] = "error";
        $arrayResponse["data"] = [];
    }


}
header('Content-type: application/json');
echo json_encode($arrayResponse);