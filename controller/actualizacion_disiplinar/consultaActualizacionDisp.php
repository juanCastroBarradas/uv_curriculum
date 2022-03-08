<?php

require_once '../../model/ActualizacionDisiplinar.php';
require_once '../../core/constants.php';

if(isset($_POST["profesorKey"])){

    $profesorKey = $_POST["profesorKey"];
    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $actualizacionDisiplinar = new ActualizacionDisiplinar();
    $actualizacionDisiplinar->setProfesionalKey($profesorKey);

    $actualizacionDisiplinar->setCondicion("persona_fkey", $actualizacionDisiplinar->getProfesionalKey(), IGUAL, NUMERO);
    $arrActualizacionDisiplinar= $actualizacionDisiplinar->consultaByIdProfesor();

    if(!empty($arrActualizacionDisiplinar)){
        if(count($arrActualizacionDisiplinar) > 0){
            $arrayResponse["msj"] = "Datos del profesor encontrados.";
            $arrayResponse["status"] = "success";
            $arrayResponse["data"] = $arrActualizacionDisiplinar;
        }
    }else{
        $arrayResponse["msj"] = "No existe informacion que coincida con el ID proporcionado.";
        $arrayResponse["status"] = "error";
        $arrayResponse["data"] = [];
    }

    header('Content-type: application/json');
	echo json_encode($arrayResponse);


}