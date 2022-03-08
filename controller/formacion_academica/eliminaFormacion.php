<?php

require_once '../../model/FormacionAcademica.php';
require_once '../../core/constants.php';

if(isset($_POST["formacion_key"]) && isset($_POST["persona_fkey"])){
    $formacion_key = $_POST["formacion_key"];
    $persona_fkey = $_POST["persona_fkey"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $formacion = new FormacionAcademica();
    $formacion->setFormacion_key($formacion_key);
    $formacion->setProfesionalKey($persona_fkey);

    //egregamos condicion sobre el id del profesor
    $formacion->setCondicion("persona_fkey", $formacion->getProfesionalKey(), IGUAL, NUMERO);
    $formacion->setCondicion("formacion_key", $formacion->getFormacion_key(), IGUAL, NUMERO);

    $formacion->deleteFormacion();

    $formacion->clearCondicion();
    $formacion->setCondicion("persona_fkey", $formacion->getProfesionalKey(), IGUAL, NUMERO);
    $aFormacion = $formacion->consultaByIdProfesor();

    $arrayResponse["msj"] = "se elimino correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aFormacion;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);

}