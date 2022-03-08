<?php

require_once '../../model/Participacion.php';
require_once '../../core/constants.php';

if(isset($_POST["participacion_key"]) && isset($_POST["persona_fkey"])){
    $participacion_key = $_POST["participacion_key"];
    $persona_fkey = $_POST["persona_fkey"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $participacion = new Participacion();
    $participacion->setParticipacionKey($participacion_key);
    $participacion->setProfesionalKey($persona_fkey);

    // agregamos condicion sobre el id del profesor
    $participacion->setCondicion("persona_fkey", $participacion->getProfesionalKey(), IGUAL, NUMERO);
    $participacion->setCondicion("participacion_key", $participacion->getParticipacionKey(), IGUAL, NUMERO);

    $participacion->eliminaParticipacion();

    $participacion->clearCondicion();
    $participacion->setCondicion("persona_fkey", $participacion->getProfesionalKey(), IGUAL, NUMERO);
    $aparticipacion = $participacion->consultaByIdProfesor();

    $arrayResponse["msj"] = "Se eliminaron correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aparticipacion;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);

}