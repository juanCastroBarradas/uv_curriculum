<?php

require_once '../../model/CapacitacionDocente.php';
require_once '../../core/constants.php';

if(isset($_POST["capacitacion_key"]) && isset($_POST["persona_fkey"])){
    $capacitacion_key = $_POST["capacitacion_key"];
    $persona_fkey = $_POST["persona_fkey"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $capacitacionDocente = new CapacitacionDocente();
    $capacitacionDocente->setCapacitacionKey($capacitacion_key);
    $capacitacionDocente->setProfesionalKey($persona_fkey);

    //egregamos condicion sobre el id del profesor
    $capacitacionDocente->setCondicion("persona_fkey", $capacitacionDocente->getProfesionalKey(), IGUAL, NUMERO);
    $capacitacionDocente->setCondicion("capacitacion_key", $capacitacionDocente->getCapacitacionKey(), IGUAL, NUMERO);

    $capacitacionDocente->deleteCapacitacion();

    $capacitacionDocente->clearCondicion();
    $capacitacionDocente->setCondicion("persona_fkey", $capacitacionDocente->getProfesionalKey(), IGUAL, NUMERO);
    $aCapacitacionDocente = $capacitacionDocente->consultaByIdProfesor();

    $arrayResponse["msj"] = "se elimino correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aCapacitacionDocente;

    
    header('Content-type: application/json');
	echo json_encode($arrayResponse);


}